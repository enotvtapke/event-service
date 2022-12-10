#!/bin/bash
docker container rm -f event-service-run
docker run --name event-service-run -d -p 80:80 event-service


docker build -t event-service .
docker tag event-service enotvtapke/personal:event-service
docker push enotvtapke/personal:event-service

docker exec -it php-postgres-1 psql -U admin -W postgres
