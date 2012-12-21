<?php
class Admin_Admin {
  private $config;
  public function __construct($conf=false) {
    $this->config=$conf;
  }
  public function action_index(){
    // DB Connect
    $pdo=new PDO('mysql:host='.
        $this->config['database']['admin']['host'].';dbname='.$this->config['database']['admin']['database'],
      $this->config['database']['admin']['user'],
      $this->config['database']['admin']['password']);
    // Delete admin
    if(isset($_GET['delete'])) {
      $pdo->query('DELETE FROM admin WHERE id = '.((int)$_GET['delete']))->execute();
    }
    // Add admin
    if(isset($_POST['newlogin']) && isset($_POST['newpassword'])) {
      $newadmin=$pdo->prepare('INSERT INTO admin (login, password) VALUES (:login, :password)');
      $newadmin->execute(array(
        ':login'=>$_POST['newlogin'],
        ':password'=>md5(md5($_POST['newlogin']).$_POST['newpassword'])
      ));
    }
    if(isset($_POST['type']) && $_POST['type']=='passwordchange') {
      $newadmin=$pdo->prepare('UPDATE admin SET password=:password WHERE id=:id');
      $newadmin->execute(array(
        ':id'=>$_POST['id'],
        ':password'=>md5(md5($_POST['login']).$_POST['passwordchange'])
      ));
    }
    // List admin
    $admin=$pdo->query('SELECT * FROM admin')->fetchAll();
    $pdo=null;
    return View::factory(array('admins'=>$admin))->display('admin/admin_list');
  }
}