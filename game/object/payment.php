<?php
class Object_Payment {
  private $config;
  private $data;
  public function __construct($config, $social){
    $this->config=$config;
    $this->db=new Mongo($config['database']['objects']['server']);
    $this->db=$this->db->{$config['database']['objects']['database']}->payments;
    $this->data=$this->db->findOne(array('social' => 'fb'));
  }
  public function get($id){
    return isset($this->data['items'][$id])?$this->data['items'][$id]:null;
  }
}