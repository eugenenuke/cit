#!/bin/bash
home=/var/www/sites/vsev7/html


sed -i 's/http:/https:/g' $home/plugins/content/jw_allvideos/includes/sources.php
sed -i 's/&\$this/\$this/g' $home/templates/rt_affinity_j15/rt_sectionrows.php
sed -i 's/&\$t/\$t/g' $home/templates/rt_affinity_j15/rt_sectionrows.php
sed -i 's/&\$c/\$c/g' $home/templates/rt_affinity_j15/rt_sectionrows.php

echo "define('JPATH_XMLRPC',                  JPATH_ROOT.DS.'xmlrpc' );" >>$home/includes/defines.php
