#!/bin/bash
home=/var/www/sites/komitet/html

sed -i '1 s/http:/https:/' $home/style.css
sed -ri 's_http(://ajax\.googleapis\.com)_https\1_' $home/index.php
sed -ri 's_http://ddut\.vsevcit\.ru_https://ddut.vsevobr.ru_' $home/index.php
chmod o+rx $home
