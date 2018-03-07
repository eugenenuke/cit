#!/bin/bash
home=/var/www/sites/dskv10/html


sed -i 's/http:/https:/g' $home/plugins/content/jw_allvideos/jw_allvideos/includes/sources.php
