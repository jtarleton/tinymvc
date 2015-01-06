<?php 

class Config
{
	const DBENABLED = true;
	public $config;
	
	private function __construct()
	{
		$this->config = array('connection' =>array(
				'dsn' => sprintf('mysql:host=%s;port=%s;dbname=%s', PVTCONFIG_DBHOST, PVTCONFIG_DBPORT, PVTCONFIG_DBNAME),
				'dialect' => '',
				'username'=> PVTCONFIG_DBUSER,
				'password'=> PVTCONFIG_DBPASS
			)
		);
	}
	static public function getInstance()
	{	
		return new self;
	}
}