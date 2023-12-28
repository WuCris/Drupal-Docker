# Drupal Docker Compose (Swarm Ready)

This repo is based off the Docker official Drupal image and is designed with modern Docker centric philosophy where code is distributed for deployment as a Docker image. 

Upstream code from Drupal is provided by upstream images. You may introduce your own modules and themes in this repo. For contrib modules it is recommended to modify the `php/Dockerfile` to install them via `composer`.

## Deployment locally

Edit the `.env` file as needed and enter randomly generated passcodes for the databases.

```
docker-compose build --pull
docker-compose up -d
```
### Install Drupal
```
docker-compose exec drupal-php drush si
docker-compose exec drupal-php drush cr
```

The site can now be visited in the browser at http://localhost:9090

## Deployment on Docker Swarm


First we need a Docker registry set up and accessible to all worker nodes in your swarm. I used [Harbor](https://goharbor.io/) as my registry. Edit docker-stack-deploy.yml and modify `image:` for the Drupal images to match your project name and repository. Login to the Docker registry on each node. Example: `docker login harbor.lan:8443`

Edit the `.env` file as needed and enter randomly generated passcodes for the databases.

**We must then build the images and push them to our registry:**

```
docker-compose -f docker-stack-deploy.yml build --pull
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

Once you have found a worker (or manager) node with the service running ssh into the node exec into it and run `drush` to install the site.


**Example:**

```
docker ps  | grep drupal-php
```

After finding the container name copy it and exec into it like below.

```
docker exec -ti drupal_drupal-php.3.7hpi34m8qjfh3skioqgq4n03w drush si
docker exec -ti drupal_drupal-php.3.7hpi34m8qjfh3skioqgq4n03w drush cr
```