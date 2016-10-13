#!/bin/bash
sudo apt-get install -y default-jre unzip
wget http://selenium-release.storage.googleapis.com/3.0-beta4/selenium-java-3.0.0-beta4.zip
unzip selenium-java-3.0.0-beta4.zip /usr/local/bin
sudo java -jar /usr/local/bin/client-combined-3.0.0-beta4-nodeps.jar