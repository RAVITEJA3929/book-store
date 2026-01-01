FROM mysql:8.0

# Force env vars (overrides entrypoint checks)
ENV MYSQL_ROOT_PASSWORD=bookstore123
ENV MYSQL_DATABASE=bookstore  
ENV MYSQL_USER=bookuser
ENV MYSQL_PASSWORD=bookpass123
ENV MYSQL_ALLOW_EMPTY_PASSWORD=yes

COPY init.sql /docker-entrypoint-initdb.d/
