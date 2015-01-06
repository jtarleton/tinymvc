<?php 
/*******************************************************************
"Controller" 
*/
//action controller
class Actions
{
	static public function getInstance()
	{ 
		return new self; 
	}
	public function dispatchRequest(array $req)
	{
		$action=(!empty($req)) ? $req['action'] : null;

	
		$data=Planet::getAllByCriteria(array('id'=>(int)$action)); // Do something with the request... get some vehicle objects!
	
		//Pass an array of objects to the view
		return Layout::callLayout($req, $data);		
	}

	
}