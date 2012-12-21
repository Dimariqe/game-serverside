<?php
class Object_Queue {
  private $db;
  public function __construct($config){
    $this->db=new Mongo($config['database']['queue']['server']);
    $this->db=$this->db->{$config['database']['queue']['database']}->{$config['database']['queue']['table']};
  }
  public function get($sid, $pid) {
    $queue=$this->db->findOne(array('sid'=> $sid, 'pid'=>$pid));
    if($queue!=null){
      $this->db->remove(array('sid'=> $sid, 'pid'=>$pid));
      return json_decode($queue['request']);
    }
    return null;
  }
  public function add($sid, $id, $request) {
    $this->db->insert(array('sid'=> $sid, 'pid'=>$id, 'request'=>$request));
  }
}