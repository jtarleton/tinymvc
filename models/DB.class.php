<?php 

/******************************************************************* 
"Model"
*/
class DB
{
	static public function getCon()
	{
		$config = Config::getInstance()->config;
		try 
		{
			if(Config::DBENABLED) 
			{
				$pdo = new PDO(@$config['connection']['dsn'], 
					@$config['connection']['username'], 
					@$config['connection']['password']
				);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $pdo; 
			}
		} 
		catch (PDOException $e) 
		{
			printf('PDO ERROR: %s', $e->getMessage());
			exit(0); 
		}
	}

}