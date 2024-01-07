# Drupal Docker Compose 
## (Swarm and Kubernetes Ready)

This repo is based off the Docker official Drupal image and is designed with modern Docker centric philosophy where code is distributed for deployment as a Docker image. 

Upstream code from Drupal is sourced from upstream images. You may introduce your own modules and themes in this repo. For contrib modules it is recommended to modify the `php/Dockerfile` to install them via `composer`.

## Deployment locally

Edit the `.env` file as needed and enter randomly generated passcodes for the databases. For example you may use `pwgen -s 20` to generate a password.

We must build the `drupal-php` first as it's a prerequisite for the `drupal-nginx` image.

```
docker-compose build --pull drupal-php
docker pull nginx:1.25-alpine
docker-compose build
docker-compose up -d
```
### Install Drupal
```
docker-compose exec drupal-php drush si
docker-compose exec drupal-php drush cr
```

The site can now be visited in the browser at http://localhost:9090

## Deployment on Docker Swarm

### Opening Services to the Outside World

We need to run an Nginx container outside of Swarm that has access to the Nginx container's network that runs within swarm. For this purpose I've created [Nginx-LB](https://github.com/WuCris/Docker-Nginx-LB). Build and launching it will create an overlay network called `nginx-lb`. The Drupal configured Nginx instance will latch onto this network opening port 80 to the outside. Read instructions on how to use nginx-lb for further information. 

### Shared storage

You'll need a volume mount that all nodes can access. This can be NFS, Glusterfs, or similar. Here we do not use Docker storage drivers (most of which are deprecated). This repo has been built and tested with GlusterFS. 

Edit `docker-stack-deploy.yml` and modify the volume mounts as needed to match your shared target storage.

```
 volumes:
      - /mnt/gluster/drupal/drupal-files:/opt/drupal/web/sites/default/files
```

Note that you'll need to generate the required sub directories. Modify the paths as needed to match your mounts in `docker-stack-deploy.yml`.
**Example:**
```
mkdir /mnt/gluster/drupal/drupal-files
mkdir /mnt/gluster/drupal/drupal-mariadb-master
mkdir /mnt/gluster/drupal/drupal-mariadb-slave
```

### Launching the Stack

We also need a Docker registry set up and accessible to all worker nodes in your swarm. I used [Harbor](https://goharbor.io/) as my registry. Edit docker-stack-deploy.yml and modify `image:` for the Drupal images to match your project name and repository. Login to the Docker registry on each node. Example: `docker login harbor.lan:8443` If you are using a self signed cert you'll need to add your `ca.crt` to `/etc/docker/certs.d/harbor.lan\:8443/ca.crt` (replace the URL with yours as needed). Then restart Docker.

Edit the `.env` file as needed and enter randomly generated passcodes for the databases.

**We must then build the images and push them to our registry:**

```
docker-compose -f docker-stack-deploy.yml build
docker-compose -f docker-stack-deploy.yml push
```

**On a Docker Swarm Manager node run the following to deploy the site:**

```
set -a; . ./.env; set +a
docker stack deploy -c docker-stack-deploy.yml drupal --with-registry-auth
```


### Install Drupal

**Verify the services are running:**

```
docker service ls
```

**Find a node with drupal-php running:**

```
docker stack ps drupal | grep -v Shutdown
```

Once you have found a worker (or manager) node with the service running. SSH into the node and `exec` into a `drupal-php` container and run `drush` to install the site.

**Example:**

```
docker ps  | grep drupal-php
```

After finding the container name copy it and exec into it like below.

```
docker exec -ti drupal_drupal-php.3.7hpi34m8qjfh3skioqgq4n03w drush si
docker exec -ti drupal_drupal-php.3.7hpi34m8qjfh3skioqgq4n03w drush cr
```

## Kubernetes

This has been tested and developed on MicroK8s releases of Kubernetes version `1.29`.

### Shared Storage

**A note on shared storage:** The Kubernetes GlusterFS plugin is deprecated. To use GlusterFS with with latest Kubernetes version `1.29` we mount a shared storage path of `/mnt/glusterfs/microk8s`. This must exist before applying the `drupal-StorageClass-k8s.yml`. Alternatively you may edit the paths for volume mounts in `k8s` configuration files for any other shared storage mounts you may use (be it NFS, MooseFS, etc).

### Create Database Secrets

Replace the content with random passwords of your own and run the following in terminal on one of your manager nodes to create database password secrets.

```
 microk8s kubectl create secret generic drupal-mariadb-password \
      --from-literal=MARIADB_ROOT_PASSWORD=RxKP0JKRyTq3H6vWpMPLpCB2A \
      --from-literal=MARIADB_PASSWORD=aE43YpngajSgwqPUydaZie2Vy \
      --from-literal=MARIADB_REPLICATION_PASSWORD=525FIVGrlTJLJZdhaEwX24KVJ \
      --from-literal=MARIADB_ROOT_REPLICA_PASSWORD=i1NIno3OV4c21XGFtBa072QlC
```

### Deployment

Here we assumed Ingress is not being used. The `drupal-loadbalancer-k8s.yml` config will port forward the Nginx instances and load balance them. Edit it as needed to change the port it'll run on. If using Ingress delete this file as it needn't apply.

To apply all k8s configuration files at once run the following.

```
microk8s kubectl apply -f k8s
```

### Install Drupal

Find the name of the pod one of your PHP containers is running in.

```
microk8s kubectl get pods
```

Copy the pod name and exec into the container like such and run the required drush commands within it.

```
microk8s kubectl exec --stdin --tty drupal-nginx-7b5f54cf84-spnrx -- sh
drush si
drush cr
```
