#!/bin/bash
sudo debconf-set-selections <<< 'mysql-apt-config mysql-apt-config/repo-codename select trusty'
sudo debconf-set-selections <<< 'mysql-apt-config mysql-apt-config/repo-distro select ubuntu'
sudo debconf-set-selections <<< 'mysql-apt-config mysql-apt-config/repo-url string http://repo.mysql.com/apt/'
sudo debconf-set-selections <<< 'mysql-apt-config mysql-apt-config/select-preview select '
sudo debconf-set-selections <<< 'mysql-apt-config mysql-apt-config/select-product select Ok'
sudo debconf-set-selections <<< 'mysql-apt-config mysql-apt-config/select-server select mysql-5.7'
sudo debconf-set-selections <<< 'mysql-apt-config mysql-apt-config/select-tools select '
sudo debconf-set-selections <<< 'mysql-apt-config mysql-apt-config/unsupported-platform select abort'

wget http://dev.mysql.com/get/mysql-apt-config_0.7.3-1_all.deb
sudo dpkg -i mysql-apt-config_0.7.3-1_all.deb
sudo apt-get update
sudo apt-get install -y mysql-community-server
#sudo /etc/init.d/mysql stop
#sudo mysqld_safe --skip-grant-tables &>/dev/null &
sudo mysql -e "USE mysql;CREATE USER 'posio'@'localhost' IDENTIFIED BY 'superstringpassword';GRANT ALL PRIVILEGES ON *.* TO 'posio'@'localhost';flush privileges;" --user=root
sudo /etc/init.d/mysql restart

wget http://selenium-release.storage.googleapis.com/3.0-beta4/selenium-java-3.0.0-beta4.zip
unzip selenium-java-3.0.0-beta4.zip /usr/local/bin
java -jar /usr/local/bin/client-combined-3.0.0-beta4-nodeps.jar