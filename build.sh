#!/bin/bash

. functions.sh

show_title "PROFIT OVERVIEW BACK"

PROJECT_NAME=profitoverview-back;

PHP_VERSION=7.3;

DB_HOST=mariadb;
DB_VERSION=10.4.11;
DB_ROOT_PASSWORD=Fcma3KmeEOdQ;
DB_NAME=integration;
DB_USER_NAME=integration;
DB_USER_PASSWORD=Fcma3KmeEOdQ;
DB_PORT=3306;

COMPOSE_PROJECT_NAME=profitoverview_laradock;

NGINX_VIRTUAL_HOST=profitoverview.loc;
NGINX_HOST_HTTP_PORT=80;
NGINX_HOST_HTTPS_PORT=443;

WORKSPACE_SSH_PORT=2222;

APP_CODE_PATH_CONTAINER=/var/www/$PROJECT_NAME;

#PROJECT_ENV_PATH=.env;
#DOCKER_ENV_PATH=../${PROJECT_NAME}/${COMPOSE_PROJECT_NAME};

PROJECT_ENV_FILE=.env;
DOCKER_ENV_FILE=${COMPOSE_PROJECT_NAME}/.env;

DOCKER_NGINX_PATH=${COMPOSE_PROJECT_NAME}/nginx;
DOCKER_HOST_CONF=${DOCKER_NGINX_PATH}/sites/${COMPOSE_PROJECT_NAME}.conf
DOCKER_PHP_FPM_FILE=${COMPOSE_PROJECT_NAME}/php-fpm/Dockerfile;
DOCKER_WORKSPACE_FILE=${COMPOSE_PROJECT_NAME}/workspace/Dockerfile;

DOCKER_COMPOSE_YAML=build-docker-compose.yml;

echo 'configuring .env file of the project';
set_env "${PROJECT_ENV_FILE}" DB_DATABASE $DB_NAME;
set_env "${PROJECT_ENV_FILE}" DB_USERNAME $DB_USER_NAME;
set_env "${PROJECT_ENV_FILE}" DB_PASSWORD $DB_USER_PASSWORD;
set_env "${PROJECT_ENV_FILE}" APP_URL "http://${NGINX_VIRTUAL_HOST}";
set_env "${PROJECT_ENV_FILE}" DB_HOST $DB_HOST;

#sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/g" ${PROJECT_NAME}/project.env;
#sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER_NAME/g" ${PROJECT_NAME}/project.env;
#sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_USER_PASSWORD/g" ${PROJECT_NAME}/project.env;
#sed -i "s!APP_URL=.*!APP_URL=http://$NGINX_VIRTUAL_HOST!g" ${PROJECT_NAME}/project.env;
#sed -i "s/DB_HOST=.*/DB_HOST=$DB_HOST/g" ${PROJECT_NAME}/project.env;
echo 'configured .env file';

echo 'configuring .env file of the docker';
set_env $DOCKER_ENV_FILE MARIADB_VERSION $DB_VERSION;
set_env $DOCKER_ENV_FILE MARIADB_DATABASE $DB_NAME;
set_env $DOCKER_ENV_FILE MARIADB_USER $DB_USER_NAME;
set_env $DOCKER_ENV_FILE MARIADB_PASSWORD $DB_USER_PASSWORD;
set_env $DOCKER_ENV_FILE MARIADB_ROOT_PASSWORD $DB_ROOT_PASSWORD;
set_env $DOCKER_ENV_FILE MARIADB_PORT $DB_PORT;
set_env $DOCKER_ENV_FILE WORKSPACE_SSH_PORT $WORKSPACE_SSH_PORT;
set_env $DOCKER_ENV_FILE COMPOSE_PROJECT_NAME $COMPOSE_PROJECT_NAME;
set_env $DOCKER_ENV_FILE NGINX_HOST_HTTP_PORT $NGINX_HOST_HTTP_PORT;
set_env $DOCKER_ENV_FILE NGINX_HOST_HTTPS_PORT $NGINX_HOST_HTTPS_PORT;
set_env $DOCKER_ENV_FILE APP_CODE_PATH_CONTAINER $APP_CODE_PATH_CONTAINER;
set_env $DOCKER_ENV_FILE PHP_VERSION $PHP_VERSION;

#sed -i "s/MARIADB_VERSION=.*/MARIADB_VERSION=$DB_VERSION/g" ${PROJECT_NAME}/docker.env;
#sed -i "s/MARIADB_DATABASE=.*/MARIADB_DATABASE=$DB_NAME/g" ${PROJECT_NAME}/docker.env;
#sed -i "s/MARIADB_USER=.*/MARIADB_USER=$DB_USER_NAME/g" ${PROJECT_NAME}/docker.env;
#sed -i "s/MARIADB_PASSWORD=.*/MARIADB_PASSWORD=$DB_USER_PASSWORD/g" ${PROJECT_NAME}/docker.env;
#sed -i "s/MARIADB_ROOT_PASSWORD=.*/MARIADB_ROOT_PASSWORD=$DB_ROOT_PASSWORD/g" ${PROJECT_NAME}/docker.env;
#sed -i "s/MARIADB_PORT=.*/MARIADB_PORT=$DB_PORT/g" ${PROJECT_NAME}/docker.env;
#sed -i "s/WORKSPACE_SSH_PORT=.*/WORKSPACE_SSH_PORT=$WORKSPACE_SSH_PORT/g" ${PROJECT_NAME}/docker.env;
#sed -i "s/COMPOSE_PROJECT_NAME=.*/COMPOSE_PROJECT_NAME=$COMPOSE_PROJECT_NAME/g" ${PROJECT_NAME}/docker.env;
#sed -i "s/NGINX_HOST_HTTP_PORT=.*/NGINX_HOST_HTTP_PORT=$NGINX_HOST_HTTP_PORT/g" ${PROJECT_NAME}/docker.env;
#sed -i "s/NGINX_HOST_HTTPS_PORT=.*/NGINX_HOST_HTTPS_PORT=$NGINX_HOST_HTTPS_PORT/g" ${PROJECT_NAME}/docker.env;
#sed -i "s!APP_CODE_PATH_CONTAINER=.*!APP_CODE_PATH_CONTAINER=$APP_CODE_PATH_CONTAINER!g" ${PROJECT_NAME}/docker.env;
#sed -i "s/PHP_VERSION=.*/PHP_VERSION=$PHP_VERSION/g" ${PROJECT_NAME}/docker.env;
echo 'configured .env file of the docker';

#echo 'configuring virtual host nginx';
#sed -i "s/server_name.*/server_name $NGINX_VIRTUAL_HOST www.$NGINX_VIRTUAL_HOST;/g" ${PROJECT_NAME}/${COMPOSE_PROJECT_NAME}.conf;
#sed -i "s!/var/www/laravel/public!/var/www/$PROJECT_NAME/public!g" ${PROJECT_NAME}/${COMPOSE_PROJECT_NAME}.conf;
#sed -i "s!access_log.*!access_log /var/log/nginx/${COMPOSE_PROJECT_NAME}_access.log;!g" ${PROJECT_NAME}/${COMPOSE_PROJECT_NAME}.conf;
#sed -i "s!error_log.*!error_log /var/log/nginx/${COMPOSE_PROJECT_NAME}_error.log;!g" ${PROJECT_NAME}/${COMPOSE_PROJECT_NAME}.conf;
#echo 'configured virtual host';

#echo "copied ${COMPOSE_PROJECT_NAME}.conf file into ${DOCKER_HOST_CONF}";
#cp ${PROJECT_NAME}/${COMPOSE_PROJECT_NAME}.conf $DOCKER_HOST_CONF;

echo 'configuring WORKDIR php-fpm';
sed -i "" "s!WORKDIR.*!WORKDIR $APP_CODE_PATH_CONTAINER!g" $DOCKER_PHP_FPM_FILE;
echo 'configured WORKDIR php-fpm';

echo 'configuring WORKDIR workspace';
sed -i "" "s!WORKDIR.*!WORKDIR $APP_CODE_PATH_CONTAINER!g" $DOCKER_WORKSPACE_FILE;
echo 'configured WORKDIR workspace';

cd ${COMPOSE_PROJECT_NAME};

echo 'run containers nginx, mariadb';
docker-compose -f ${DOCKER_COMPOSE_YAML} up -d nginx mariadb;

echo 'run composer install';
docker-compose -f ${DOCKER_COMPOSE_YAML} exec workspace composer install;

echo 'generate app key';
docker-compose -f ${DOCKER_COMPOSE_YAML} exec workspace php artisan key:generate;

echo 'run migrations';
docker-compose -f ${DOCKER_COMPOSE_YAML} exec workspace php artisan migrate;

echo 'run seeds';
docker-compose -f ${DOCKER_COMPOSE_YAML} exec workspace php artisan db:seed;

#echo 'run npm install';
docker-compose -f ${DOCKER_COMPOSE_YAML} exec workspace npm install;

#echo 'build frontend';
docker-compose -f ${DOCKER_COMPOSE_YAML} exec workspace npm run dev;

show_title "PROFIT OVERVIEW BACK"