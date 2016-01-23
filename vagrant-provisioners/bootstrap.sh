#!/bin/bash
#
# Vagrant bootstrap, written by Dr. Joksimovic
#

# Update repositories
apt-get update

# PHP tools
apt-get install -y php5-xdebug php5-xmlrpc mc default-jre

echo "; xdebug
xdebug.remote_connect_back = 1
xdebug.remote_enable = 1
xdebug.remote_handler = \"dbgp\"
xdebug.remote_port = 9000
xdebug.var_display_max_children = 512
xdebug.var_display_max_data = 1024
xdebug.var_display_max_depth = 10
xdebug.idekey = \"PHPSTORM\"" >> /etc/php5/apache2/php.ini

sed 's#DocumentRoot /var/www/public#DocumentRoot /var/www/web#g' /etc/apache2/sites-available/000-default.conf > /etc/apache2/sites-available/000-default.conf.tmp
mv /etc/apache2/sites-available/000-default.conf.tmp /etc/apache2/sites-available/000-default.conf


# Install RabbitMQ
sudo apt-get install -y rabbitmq-server


# Finally, restart apache
service apache2 restart


#
# Increase machine swap size, because composer requires
# a lot of energy :D
#

# size of swapfile in megabytes
swapsize=8000

# does the swap file already exist?
grep -q "swapfile" /etc/fstab

# if not then create it
if [ $? -ne 0 ]; then
  echo 'swapfile not found. Adding swapfile.'
  fallocate -l ${swapsize}M /swapfile
  chmod 600 /swapfile
  mkswap /swapfile
  swapon /swapfile
  echo '/swapfile none swap defaults 0 0' >> /etc/fstab
else
  echo 'swapfile found. No changes made.'
fi

# output results to terminal
df -h
cat /proc/swaps
cat /proc/meminfo | grep Swap

/usr/local/bin/composer self-update

cd /var/www; composer install

mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS followuply"

