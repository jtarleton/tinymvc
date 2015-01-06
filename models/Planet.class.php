<?php 

/* 



CREATE TABLE IF NOT EXISTS `planets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_url` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `planets`
--

INSERT INTO `planets` (`id`, `name`, `img_url`, `description`) VALUES
(1, 'Neptune', 'http://upload.wikimedia.org/wikipedia/commons/0/06/Neptune.jpg', 'Neptune is the eighth and farthest planet from the Sun in the Solar System. It is the fourth-largest planet by diameter and the third-largest by mass. Among the gaseous planets in the Solar System, Neptune is the most dense. Neptune is 17 times the mass of Earth and is slightly more massive than its near-twin Uranus, which is 15 times the mass of Earth but not as dense.[c] Neptune orbits the Sun at an average distance of 30.1 astronomical units. Named after the Roman god of the sea, its astronomical symbol is ♆, a stylised version of the god Neptune''s trident.'),
(2, 'Earth', 'http://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Earth_Eastern_Hemisphere.jpg/300px-Earth_Eastern_Hemisphere.jpg', 'Earth'),
(3, 'Uranus', 'http://upload.wikimedia.org/wikipedia/commons/3/3d/Uranus2.jpg', 'Uranus'),
(4, 'Jupiter', 'http://upload.wikimedia.org/wikipedia/commons/5/5a/Jupiter_by_Cassini-Huygens.jpg', 'Jupiter'),
(5, 'Saturn', 'http://upload.wikimedia.org/wikipedia/commons/2/25/Saturn_PIA06077.jpg', 'Saturn'),
(6, 'Mars', 'http://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/Water_ice_clouds_hanging_above_Tharsis_PIA02653_black_background.jpg/800px-Water_ice_clouds_hanging_above_Tharsis_PIA02653_black_background.jpg', 'Mars'),
(7, 'Venus', 'http://upload.wikimedia.org/wikipedia/commons/thumb/8/85/Venus_globe.jpg/250px-Venus_globe.jpg', 'Venus'),
(8, 'Mercury', 'http://upload.wikimedia.org/wikipedia/commons/3/30/Mercury_in_color_-_Prockter07_centered.jpg', 'Mercury');

*/


class Planet extends DB
{
    public $db;
	public $id;
	
	public function __construct($id = null, $data = array())
	{
		$this->db = parent::getCon();
		$this->id = (int)$id;
		if(!empty($data)){
			$this->name = @$data['name'];
			$this->img_url = @$data['img_url'];
			$this->description = @$data['description']; 
		}
		
	}
	public function getPrev(){
		$prevID = $this->id - 1;
		$prevObj = new self($prevID);
		return $prevObj;
	}
	public function getNext(){
		$nextID = $this->id + 1;
			
		$nextObj = new self($nextID);
		return $nextObj;
	}
	
	static public function getAllByCriteria($criteria = array())
	{
		$db = parent::getCon();
		$objs = array();
		$sql = 'select * from planets';
		
	
		if(!empty($criteria)){
			$sql .= ' where '; 
		}

		$pieces = array();
		foreach($criteria as $fld=>$v){
			$pieces[] = $fld.'=:'.$fld;
		}
		if(!empty($pieces))
		$sql .= implode('AND', $pieces);

		$stmt = $db->prepare($sql);
		foreach($criteria as $fld=>$v) {
			$stmt->bindValue(":$fld", $v, PDO::PARAM_STR);	
		}


		$stmt->execute();
		while($row = $stmt->fetch()){
			$objs[$row['id']] = new self($row['id'], $row); 
		}
	
		return $objs;
	}
}