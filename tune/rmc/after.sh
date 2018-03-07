#!/bin/bash
home=/var/www/sites/rmc/html

sed -ri 's_http(://ajax\.googleapis\.com)_https\1_' $home/index.php
sed -ri 's_http://komitet\.vsv\.lokos\.net_https://komitet.vsevobr.ru_' $home/index.php
chmod o+rx $home
