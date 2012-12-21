<?php
class Helper_Session{

	private $data = array();
	private $session_id;
	private $db;

	function __construct($config, $sid_name='session_id'){
		$this->db=new Mongo($config['server']);
		$this->db=$this->db->{$config['database']}->session;
		if(!isset($_COOKIE[$sid_name])){
			$this->data['start']=time();
			$this->db->insert($this->data);
			$this->session_id = new MongoId($this->data['_id']);
			setcookie($sid_name, $this->session_id);
		} else {
			$this->session_id = htmlspecialchars($_COOKIE[$sid_name]);
			$this->data = $this->db->findOne(
				array(
					'_id' => new MongoId($this->session_id)
				)
			);
		}
	}


	public function get($param, $default=false){
		return isset($this->data[$param]) ? $this->data[$param] : $default;
	}
  public function getAll(){ return $this->data; }

	public function set($param, $value){
		$this->data[$param] = $value;
		$this->db->save($this->data);
	}
  public function setArr($param){
    foreach($param as $k=>$v){
      $this->data[$k] = $v;
    }
    $this->db->save($this->data);
  }

	public function destroy(){
		$this->db->remove(
			array('_id' => new MongoId($this->session_id))
		);
		setcookie($session_id);
	}

}
