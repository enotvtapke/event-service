#!/bin/bash
docker container rm -f event-service-run
docker build -t event-service .
#docker run --name event-service-run -d -p 80:80 event-service