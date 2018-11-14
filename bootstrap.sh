#!/usr/bin/env bash

Update () {
    echo "-- Update packages --"
    sudo apt-get update
    sudo apt-get upgrade
}
Update

echo "-- Prepare configuration for MySQL --"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password root"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password root"

echo "-- Install tools and helpers --"
sudo apt-get install -y --force-yes python-software-properties vim htop curl git npm mc

echo "-- Install PPA's --"
sudo add-apt-repository ppa:ondrej/php
# sudo add-apt-repository ppa:ondrej/php5-5.6
sudo add-apt-repository ppa:chris-lea/redis-server
Update

echo "-- Install NodeJS --"
curl -sL https://deb.nodesource.com/setup_5.x | sudo -E bash -

echo "-- Install packages --"
sudo apt-get install -y --force-yes apache2 mysql-server-5.6 git-core nodejs rabbitmq-server redis-server
#sudo apt-get install -y --force-yes php7.0-common php7.0-dev php7.0-json php7.0-opcache php7.0-cli libapache2-mod-php7.0 php7.0 php7.0-mysql php7.0-fpm php7.0-imap php7.0-curl php7.0-gd php7.0-mcrypt php7.1-mbstring php7.0-bcmath php7.0-xml php7.0-zip libphp7.0-embed
sudo apt-get install -y --force-yes php7.1-common php7.1-dev php7.1-json php7.1-opcache php7.1-cli libapache2-mod-php7.1 php7.1 php7.1-mysql php7.1-fpm php7.1-imap php7.1-curl php7.1-gd php7.1-mcrypt php7.1-mbstring php7.1-bcmath php7.1-xml php7.1-zip libphp7.1-embed
#sudo apt-get install -y --force-yes php7.2-common php7.2-dev php7.2-json php7.2-opcache php7.2-cli libapache2-mod-php7.2 php7.2 php7.2-mysql php7.2-fpm php7.2-imap php7.2-curl php7.2-gd php7.2-mcrypt php7.2-mbstring php7.2-bcmath php7.2-xml php7.2-zip libphp7.2-embed
Update

echo "-- Configure PHP &Apache --"
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.0/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.0/apache2/php.ini
sudo a2enmod rewrite

echo "-- Creating virtual hosts --"
sudo ln -fs /vagrant/varta-gewinnspiel/var/www
sudo truncate /etc/apache2/sites-available/default.conf --size 0
cat << EOF | sudo tee -a /etc/apache2/sites-available/default.conf
<VirtualHost *:80>
    DocumentRoot /var/www/varta-gewinnspiel/public
    ServerName varta-gewinnspiel.vagrant
    ServerAlias *.varta-gewinnspiel.vagrant
    <Directory /var/www/varta-gewinnspiel/public>
        AllowOverride None
        Order Allow,Deny
        Allow from All

        FallbackResource /index.php
    </Directory>
    <Directory /var/www/varta-gewinnspiel/public/bundles>
        FallbackResource disabled
    </Directory>
    LogLevel warn
    CustomLog /var/log/apache2/varta-gewinnspiel-access.log combined
    ErrorLog /var/log/apache2/varta-gewinnspiel-error.log
</VirtualHost>
EOF
sudo a2ensite default.conf

echo "-- Restart Apache --"
sudo /etc/init.d/apache2 restart

echo "-- Install Composer --"
curl -s https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

#echo "-- Setup databases --"
mysql -uroot -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root' WITH GRANT OPTION; FLUSH PRIVILEGES;"
mysql -uroot -proot -e "CREATE DATABASE varta_gewinnspiel_dev";
