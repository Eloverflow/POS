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

DB_TEST_PASSWORD=grep 'temporary password' /var/log/mysql/error.log

echo DB_TEST_PASSWORD