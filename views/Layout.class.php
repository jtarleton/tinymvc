<?php 

/******************************************************************* 
"View"
*/

class Form
{
	static public function rndr($action)
	{
		$form = '<form action="index.php" method="get"><label for="action">Your Selection: </label><select id="food" name="action" onChange="mysubmit(form);">';
		$form .= (empty($action)) ? '<option selected="selected" value =\'\'>Select</option>'
			:'<option value =\'\'>Select</option>';
		foreach(Planet::getAllByCriteria() as $obj)
		{
			$sel =($obj->id==$action) ?'selected="selected"' : '';
			$form .= sprintf('<option %s value="%s">%s</option>', $sel, $obj->id, $obj->name);
		} 
		$form .= '</select></form><br />'; 
		return $form;
	} 
}
class LeftSidebar {

	public $data;

	public function __construct($data){
		$this->data = $data;
	}

	public function getData(){
		/*
		foreach($this->data as $obj)
		{ 

		}  */
		return $this->data;
	}

	public function render(){ 
		?>
		<h2>Planets</h2>
		<ul>
		<?php foreach($this->getData() as $obj) echo '<li>'.$obj->name.'</li>'; ?></ul><?php
	}
}
class RightSidebar {

	public $data;

	public function __construct($data){
		$this->data = $data;
	}

	public function getData(){
		/*
		foreach($this->data as $obj)
		{ 

		}  */
		return $this->data;
	}

	public function render(){ 
		?>
		<h2>Planets</h2>
		<ul>
		<?php foreach($this->getData() as $obj) echo '<li>'.$obj->name.'</li>'; ?></ul><?php
	}
}

class Content{
	public function __construct($action, $data){
		$this->action = $action;
		$this->data = $data;

	}
	public function render(){

		echo Form::rndr($this->action);
		if(!empty($this->data)){
		// An array of objects
			foreach($this->data as $obj)
			 echo sprintf('<div><img style="background:#F0F0F0; border:1px solid #CCC; padding:3px; width:300px; height:300px;" src="%s"></img><br /><p><br />%s</p></div>
<p><br /><a href="index.php?action=%s">&lt; Previous</a> | %s | <a href="index.php?action=%s">Next &gt;</a></p>', 
				$obj->img_url,  $obj->description, $obj->getPrev()->id, $obj->name, $obj->getNext()->id
			); 	 
		} else {
			//...or 404 redirect... 
			echo '<div>Please make a selection.</div>';
		}

		
	}
}
class Layout
{

	static public function getFormat()
	{
		
		$f= file_get_contents('themes\xyztheme\head.html');  
		$f.= file_get_contents('themes\xyztheme\left.html');
		$f.= file_get_contents('themes\xyztheme\main.html');
		$f.= file_get_contents('themes\xyztheme\right.html');
		
		$f.= file_get_contents('themes\xyztheme\foot.html');

		$f=trim($f);
		return $f;		
	}

	//call html w request and presentation array
	static public function callLayout(array $req, array $data)
	{ 
		//Render Left
		$leftSidebar = new LeftSidebar(Planet::getAllByCriteria());
		ob_start();
		$leftSidebar->render();
		$left = ob_get_clean();

		//Render Main
		ob_start();
		$action=(!empty($req)) ? $req['action'] : null;
		$content = new Content($action, $data);
		$content->render();
		$main = ob_get_clean();

		//Render Right
		$rightSidebar = new RightSidebar(Planet::getAllByCriteria());
		ob_start();
		$rightSidebar->render();
		$right = ob_get_clean();

		//Finally, output HTML template, replacing placeholder with everything in the output buffers		
		echo sprintf(self::getFormat(),$left, $main, $right);
	}
}

