# full-stack-app

Creating a 'social media' type app using a vue petite, tailwind, php, SQL and docker stack

## To up the container

Simply run <code>docker-compose up</code> to up the docker image

## To get mysqli

Open up the docker container with the <code>php:apache</code> image, then run 

<code>docker-php-ext-install mysqli</code>

If this still does not work, restart the container using <code>ctrl + c</code> then <code> docker-compose down</code>
