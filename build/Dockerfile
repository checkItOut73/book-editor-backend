FROM php:8-apache-buster

# copy vhost.conf for apache server
COPY build/configs/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update

# install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# microsoft packages public key
RUN apt-get install gnupg2 -y
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update

# install odbc driver for mssql
RUN ACCEPT_EULA=Y apt-get install msodbcsql17 -y
RUN apt-get install unixodbc-dev -y

# install sqlsrv for msssql
RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv

# use production php.ini
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# enable sqlsrv in php.ini
RUN echo 'extension=sqlsrv.so\n' >> /usr/local/etc/php/php.ini
RUN echo 'extension=pdo_sqlsrv.so\n' >> /usr/local/etc/php/php.ini

# enable xdebug coverage in php.ini
RUN echo 'xdebug.mode=coverage\n' >> /usr/local/etc/php/php.ini

# enable mod rewrite
RUN a2enmod rewrite

# restart apache server
RUN /etc/init.d/apache2 restart