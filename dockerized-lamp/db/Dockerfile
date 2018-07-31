FROM mysql:5.5
RUN chown -R mysql:root /var/lib/mysql/

ARG MYSQL_DATABASE
ARG MYSQL_ROOT_PASSWORD

ENV MYSQL_DATABASE=$MYSQL_DATABASE
ENV MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD

ADD ReachOutDB.sql /Documents/ReachOutDB.sql
RUN cp /Documents/ReachOutDB.sql /docker-entrypoint-initdb.d

EXPOSE 3306
