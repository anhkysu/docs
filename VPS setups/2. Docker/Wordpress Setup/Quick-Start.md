Define the project
Create an empty project directory.

You can name the directory something easy for you to remember. This directory is the context for your application image. The directory should only contain resources to build that image.

This project directory contains a docker-compose.yml file which is complete in itself for a good starter wordpress project.

Tip: You can use either a .yml or .yaml extension for this file. They both work.

Change into your project directory.

For example, if you named your directory my_wordpress:

cd my_wordpress/
Create a docker-compose.yml file that starts your WordPress blog and a separate MySQL instance with a volume mount for data persistence:

version: '3.3'

services:
   db:
     image: mysql:5.7
     volumes:
       - db_data:/var/lib/mysql
     restart: always
     environment:
       MYSQL_ROOT_PASSWORD: somewordpress
       MYSQL_DATABASE: wordpress
       MYSQL_USER: wordpress
       MYSQL_PASSWORD: wordpress

   wordpress:
     depends_on:
       - db
     image: wordpress:latest
     ports:
       - "8000:80"
     restart: always
     environment:
       WORDPRESS_DB_HOST: db:3306
       WORDPRESS_DB_USER: wordpress
       WORDPRESS_DB_PASSWORD: wordpress
       WORDPRESS_DB_NAME: wordpress
volumes:
    db_data: {}