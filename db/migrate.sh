liquibase \
update \
--url="jdbc:postgresql://${DB_HOST:-localhost}:${DB_PORT:-5432}/${DB_NAME:-postgres}" \
--username="${DB_USER:-admin}" \
--password="${DB_PASS:-admin}" \
--classpath="${DB_DRIVER_CLASSPATH:-./postgresql-42.5.1.jar}"