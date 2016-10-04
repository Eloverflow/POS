#!/bin/bash

mysql --execute "CREATE DATABASE IF NOT EXISTS \`POS\`;" --user=root
mysql --execute "USE \`POS\`;" --user=root
mysql --execute "CREATE USER 'POS'@'localhost';" --user=root
mysql --execute "GRANT ALL PRIVILEGES ON \`POS\`.* TO 'POS'@'localhost';" --user=root
mysql --execute "FLUSH PRIVILEGES;" --user=root