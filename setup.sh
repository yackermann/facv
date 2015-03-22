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

#Apache restart
sudo /etc/init.d/apache2 restart