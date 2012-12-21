<?php
class Object_Session {
  private $db;
  private $data=null;
  public function __construct($config, $force=false, $database='session'){
    $this->db=new Mongo($config['database'][$database]['server']);
    $this->db=$this->db->{$config['database'][$database]['database']}->{$config['database'][$database]['table']};
    if(isset($_COOKIE[$database])) {
      if(!$force) $this->data=$this->db->findOne(array('_id'=>new MongoId($_COOKIE[$database])));
      if($this->data==null) unset($_COOKIE[$database]);
    }
    if(!isset($_COOKIE[$database])){
      self::SessionInit();
      $this->db->insert($this->data);
      setcookie($database, (string)$this->data['_id']);
    }
  }
  private function SessionInit(){
    $this->data=array(
      'time'=>time(),
      'pid'=>0
    );
  }
  public function __get($key) {
    if($key=='id') return (string) $this->data['_id'];
    return isset($this->data[$key])?$this->data[$key]:null;
  }
  function __set($key, $value) {
    $this->data[$key]=$value;
    $this->db->save($this->data);
    $this->data['pid'];
  }
}