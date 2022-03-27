#!/bin/bash

# Env Vars:
# REGISTRY: name of the image registry/namespace to store the images
#
# NOTE: to run this you MUST set the REGISTRY environment variable to
# your own image registry/namespace otherwise the `docker push` commands
# will fail due to an auth failure. Which means, you also need to be logged
# into that registry before you run it.

set -ex
if [[ $REGISTRY = "" ]]; then
  echo "You must set the REGISTRY environment variable to the name of your docker registry."
  exit 1
fi
if [[ $DOCKER_HUB_PASSWD = "" ]]; then
  echo "You must set the REGISTRY environment variable to the name of your docker registry."
  exit 1
fi

docker login -u "bwalia" -p "${DOCKER_HUB_PASSWD}" docker.io

# Build the image
docker build -t ${REGISTRY}/openresty-php5 .

# And push it
docker push ${REGISTRY}/openresty-php5

#docker run -p 9000:9000 -it php5
docker run -p 8085:80 ${REGISTRY}/openresty-php5
