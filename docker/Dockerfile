# our base image
FROM ubuntu:16.04

RUN mkdir -p /var/www/dev
WORKDIR /var/www/dev

RUN apt-get update && apt-get install -y \
curl tar git nano mc
