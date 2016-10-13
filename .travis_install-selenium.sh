#!/bin/bash
sudo apt-get install -y default-jre unzip
wget https://goo.gl/LSKE9I -O selenium-server-standalone-3.0.0.jar
sudo java -jar selenium-server-standalone-3.0.0.jar