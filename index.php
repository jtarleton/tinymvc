<?php 
/*
	Tiny MVC, v.1.0.
	Author: James Tarleton

	System Requirements:
		* A web server running PHP 5.x+
		* A MySQL database 
		
	Setup:
		1. Supply your DB credentials in privateconfig.inc.php
		2. Add some view markup or use default
*/

// config, models, views, action controllers
require_once('privateconfig.inc.php');
require_once('models/Config.class.php');
require_once('models/DB.class.php');
require_once('models/Planet.class.php');
require_once('views/Layout.class.php');
require_once('controllers/Actions.class.php');
Actions::getInstance()->dispatchRequest($_REQUEST);
exit(0);