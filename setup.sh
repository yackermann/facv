#!/usr/bin/env bash

#Updating and instaling depencies
sudo apt-get -y update
sudo apt-get -y upgrade

#Pre-set deb-configs
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/dbconfig-install boolean true'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/app-password-confirm password root'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/admin-pass password root'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/app-pass password root'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2'

#Installing LAMP stack
sudo apt-get -y install apache2
sudo apt-get -y install mysql-server libapache2-mod-auth-mysql php5-mysql
sudo apt-get -y install php5 libapache2-mod-php5 php5-mcrypt

#MySQL configuration
sudo mysql_install_db
sudo apt-get -y install phpmyadmin

#PHP configuration
sudo cat <<EOT > /etc/apache2/mods-enabled/dir.conf
<IfModule mod_dir.c>
        DirectoryIndex index.php index.html index.cgi index.pl index.php index.xhtml index.htm
</IfModule>
EOT
sudo a2enmod rewrite

#Ownership fix for html
sudo chown -R vagrant:vagrant /var/www/html

#Creates index.php if it is not exists
if [ ! -f /var/www/html/index.php ] ; then echo "<?php phpinfo(); ?>" > /var/www/html/index.php; fi

#UGLY Apache fixed config
sudo mv /etc/apache2/apache2.conf /etc/apache2/apache2.conf_old
sudo cat <<ACF > /etc/apache2/apache2.conf
#I know its ugly... Please... Hate me...
Mutex file:${APACHE_LOCK_DIR} default
PidFile ${APACHE_PID_FILE}
Timeout 300
KeepAlive On
MaxKeepAliveRequests 100
KeepAliveTimeout 5
User ${APACHE_RUN_USER}
Group ${APACHE_RUN_GROUP}
HostnameLookups Off
ErrorLog ${APACHE_LOG_DIR}/error.log
LogLevel warn
IncludeOptional mods-enabled/*.load
IncludeOptional mods-enabled/*.conf
Include ports.conf
<Directory />
	Options FollowSymLinks
	AllowOverride None
	Require all denied
</Directory>
<Directory /usr/share>
	AllowOverride None
	Require all granted
</Directory>
<Directory /var/www/>
	Options Indexes FollowSymLinks
	AllowOverride All
	Require all granted
</Directory>
AccessFileName .htaccess
<FilesMatch "^\.ht">
	Require all denied
</FilesMatch>
LogFormat "%v:%p %h %l %u %t \"%r\" %>s %O \"%{Referer}i\" \"%{User-Agent}i\"" vhost_combined
LogFormat "%h %l %u %t \"%r\" %>s %O \"%{Referer}i\" \"%{User-Agent}i\"" combined
LogFormat "%h %l %u %t \"%r\" %>s %O" common
LogFormat "%{Referer}i -> %U" referer
LogFormat "%{User-agent}i" agent
IncludeOptional conf-enabled/*.conf
IncludeOptional sites-enabled/*.conf
ACF

#Apache restart
sudo /etc/init.d/apache2 restart