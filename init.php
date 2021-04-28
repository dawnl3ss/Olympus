<?php

require_once "App/Autoloader.php";
__load_all_classes();

SqlManager::__init_all_tables();
echo "All tables init.";