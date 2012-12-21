<?php
class Admin {
	private $social;
	private $session;
	private $config;
	private $template;
	public function  __construct($social){
    // Выход
    if(isset($_GET['logout']) && $_GET['logout']==$_COOKIE['admin']) {
      setcookie ("admin", "", time() - 3600);
      unset($_COOKIE['admin']);
    }
    // Инициализация
		$this->social=$social;
		$this->config=include 'config.php';
		$this->session=new Helper_Session($this->config['database']['admin_session'], 'admin');
		$this->template=new View(array(), 'admin/template', true);
    // Авторизация
    $auth_error=false;
		if(!$this->session->get('sign')) {
			if(isset($_POST['login']) && isset($_POST['password'])) {
        $pdo=new PDO('mysql:host='.
          $this->config['database']['admin']['host'].';dbname='.$this->config['database']['admin']['database'],
          $this->config['database']['admin']['user'],
          $this->config['database']['admin']['password']);
        $admin=$pdo->prepare('SELECT * FROM admin WHERE login=:login AND password=:password');
        $admin->execute(array(
          ':login'=>$_POST['login'],
          ':password'=>md5(md5($_POST['login']).$_POST['password'])
        ));
        $pdo=null;
        if($info=$admin->fetch()){
          $this->session->setArr(array(
            'sign'=>true,
            'login'=>$info['login'],
            'id'=>$info['id']
          ));
        } else $auth_error=true;
      }
		}

    // Проверка авторизации
    if(!$this->session->get('sign')) {
      self::login($auth_error);
      exit;
    } else $this->template->sign=true;

    // Весь AJAX идет мимо
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      self::ajax();
      exit;
    }
	}

  // Форма авторизации
	private function login($error=false) {
		$this->template->content=View::factory(array('error'=>$error))->display('admin/login');
	}
  private function ajax() {

  }

  // Вывод страницы
	public function html($defact='admin') {
    if(!isset($_GET['act'])) $_GET['act']=$defact;
    $controller_name='Admin_'.ucwords($_GET['act']);
    $controller= new $controller_name($this->config);
    $this->template->topmenu=View::factory()->display('admin/topmenu');
    $this->template->content=View::factory(array('inc'=>$controller->action_index()))->display('admin/content');
	}
}