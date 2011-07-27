AssoManager
============

What's that?
--------------
AssoManager is an early-stage project which aims to provide a simple yet powerful IT system to French Association Loi 1901.

Contribution
---------------------
As the project is still in conception stage, contributors interested in it should contribute only on few points, like UI, enhancement, etc. Don't hesitate to contact me.

Configuration
-------------
* AssoManager is Symfony2-based so please meet the Symfony2-RC6 requirements and configuration;
* Run bin/vendors.php
* Configure the location of winzou namespace in autoload.php (winzouCacheBundle is not managed by the vendors script)
* Create app/config/parameters_(prod|dev).ini according to parameters_example.ini
* Run assetic:dump (but NOT assets:install for now as real assets are in web/bundles (thx assetic...))