liquibase \
--search-path=. \
update \
--changelog-file=index.yaml \
--url="jdbc:postgresql://localhost:5432/postgres" \
--username="admin" \
--password="admin"
# TODO Env variables. Maybe even liquibase.properties file?