FROM ubuntu:trusty

RUN apt-get update

RUN apt-get -y --no-install-recommends install curl apt-transport-https ca-certificates software-properties-common

RUN add-apt-repository ppa:ondrej/php  && \
	apt-get update

RUN apt-get -y install apache2

RUN apt-get -y install php7.1

Run systemctl restart apache2

RUN sed -i "$ s|\-n||g" /usr/bin/pecl

RUN apt-get install -y php-pear

RUN apt-get install -y php-xml php7.1-xml

RUN /usr/bin/pecl install mongodb

RUN echo "extension=mongodb.so" > /etc/php/7.1/fpm/conf.d/20-mongodb.ini && \
	echo "extension=mongodb.so" > /etc/php/7.1/cli/conf.d/20-mongodb.ini && \
	echo "extension=mongodb.so" > /etc/php/7.1/mods-available/mongodb.ini

