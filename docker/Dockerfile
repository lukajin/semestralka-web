# syntax=docker/dockerfile:1.4
FROM alpine:3.17

RUN <<EOF
# install Apache, MariaDB, PHP + Composer
apk --no-cache add mariadb mariadb-client apache2 php81-apache2 \
php81-pdo_mysql php81-session php81-intl php81-opcache composer tzdata

# set time zone; no other time zone data are necessary
cp /usr/share/zoneinfo/Europe/Prague /etc/localtime
apk del tzdata

# fancy shell prompt like root@<container-id>:/$ instead of just '/ #' (run 'sh -l')
cat <<EOI >/etc/profile.d/prompt.sh
export PS1="\u@\h:\w\$ "
EOI

# override document root
cat <<EOI >/etc/apache2/conf.d/web.conf 
DocumentRoot "/web/public"
<Directory "/web/public">
Require all granted
</Directory>
EOI

# NOTE: to reset and reinstall the database (useful during development), run:
#   mysqladmin shutdown
#   rm -r /var/lib/mysql/* (DO NOT delete /var/lib/mysql itself!)
# then restart the container

# ensure all data directories needed by Apache/MariaDB exist and have correct permissions
# default situation looks like this:
# /run/apache2: root:root (need owner 'apache')
# /var/log/apache2: root:wheel (need owner 'apache')
# /var/www: root:root
# /run/mysqld: missing (need owner 'mysql')
# /var/lib/mysql: mysql:mysql (empty) (OK)
mkdir -p /run/mysqld
chown mysql /run/mysqld
chown apache /var/log/apache2 /run/apache2

# create a script that starts everything up when the container is started
cat <<EOI >/entry.sh
#!/bin/sh
su -s /usr/sbin/httpd apache
if test ! -f /var/lib/mysql/ibdata1 # database not set up = first start
then
    mariadb-install-db --user=mysql --ldata=/var/lib/mysql
    mysqld_safe --user=mysql &
    if test -f /web/composer.json
    then
        cd /web
        composer --no-cache install
    fi
    if test -d /web/public/uploads
    then
        chown -R apache /web/public/uploads
    fi
    while ! mysqladmin ping --silent
    do
        sleep 1
    done
    mysql <<EOS
        delete from mysql.global_priv where User='';
        --drop database if exists test;
        --delete from mysql.db where Db='test' OR Db='test\\_%';
        flush privileges;
EOS
    for f in /web/dbsetup/*.sql
    do
        mysql < \$f
    done
else
    mysqld_safe --user=mysql
fi

# exiting this script would normally stop the container
while true
do
    sleep 100000
done
EOI

chmod +x /entry.sh
EOF

EXPOSE 80

ENTRYPOINT ["/entry.sh"]
