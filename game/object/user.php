<?php
class Object_User {
  private $db;
  private $data=array();
  public function __construct($config, $uid){
    $this->db=new Mongo($config['database']['user']['server']);
    $this->db=$this->db->{$config['database']['user']['database']}->{$config['database']['user']['table']};
    $this->data=$this->db->findOne(array('uid'=>$uid));
    if($this->data==null) {
      $this->data=array('uid'=>$uid);
      self::UserInit();
      $this->db->insert($this->data);
    }
  }
  public function __destruct(){
    $this->db->insert($this->data);
  }
  private function UserInit(){
    $this->data['init']=true;
  }
  public function __get($key) {
    if($key=='id') return (string) $this->data['_id'];
    return isset($this->data[$key])?$this->data[$key]:null;
  }
  function __set($key, $value) {
    return $this->data[$key]=$value;
  }
  public function get($key) {
    if($key=='id') return (string) $this->data['_id'];
    return isset($this->data[$key])?$this->data[$key]:null;
  }
  function set($key, $value) {
    return $this->data[$key]=$value;
  }
}