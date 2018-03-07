#!/bin/bash
home=/var/www/sites/ddut/html

sed -i 's/http:/https:/g' $home/templates/standart/tmpl/header-newspage.php
sed -i 's/http:/https:/g' $home/templates/standart/tmpl/header-page.php
sed -i 's/http:/https:/g' $home/templates/standart/tmpl/header.php
