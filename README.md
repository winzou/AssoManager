AssoManager
========================

What's that?
--------------

AssoManager is an early-stage project which aims to provide a simple yet powerful IT system to French Association Loi 1901.

Contribution
---------------------

As the project is not started yet, and is still in conception stage, contributors interested in it should wait till I release a first shot.

Configuration
-------------

* AssoManager is Symfony2-based so please meet the Symfony2-beta2 requirements and configuration;
* Add symfony's vendors
* Add winzouBookBundle and customize the namespace winzou in app/autoload.php
* Run bin/build_bootstrap.php after updating vendors;
* Add app/config/parameters_prod|dev.ini according to parameters_example.ini