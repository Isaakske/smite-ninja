FROM nginx:1.11-alpine

MAINTAINER Isaak De Backer <isaak.de.backer@hotmail.com>

RUN apk add -U tzdata \
  && cp /usr/share/zoneinfo/Europe/Brussels /etc/localtime \
  && echo "Europe/Brussels" > /etc/timezone \
  && apk del tzdata

COPY docker/nginx/conf/upstream.conf /etc/nginx/conf.d/upstream.conf
COPY docker/nginx/conf/php-fpm.conf /etc/nginx/conf.d/php-fpm.conf

# remove default config from base image
RUN rm /etc/nginx/conf.d/default.conf
