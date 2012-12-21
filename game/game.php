<?php
class Game {
	public $config = null;
	public $social = null;
	public $mode	 = null;
	public $session= null;
  public $user   = null;
	function __construct($social, $force=true){
		$this->config=include 'config.php';
		$this->session=new Object_Session($this->config, $force);
    $this->social='Social_'.strtoupper($social);
    $this->social=new $this->social($this->config, $this->session);
    //$this->user=new Object_User($this->config, $this->social->get_uid());
	}

	public function show_iframe() {
    $this->social->show_iframe(array('servers'=>$this->config['servers']));
	}
	public function gateway() {
    // Определяем PID если он не определен!

    $request=json_decode($_REQUEST['request']);

    $repsone=array();
	
    $queue=new Object_Queue($this->config, $this->session->id);
    // Если ожидаемый PID не равен PID запроса
    if($this->session->pid!=$request->Pid) {
      // Добавляем запрос в ожидающие
      $queue->add($this->session->id, $request->Pid, $_REQUEST['request']);
      // Цикл до исключения
      array_merge($repsone, self::check_queue($queue));
      if($this->session->pid<$request->Pid)
      $repsone[]=array('Status'=>'Reject', 'SPID'=>$this->session->pid, 'RPID'=>$request->Pid);
      echo json_encode($repsone);
      exit;
    }
	$repsone[]=Request::a($request, $this->session->pid);
    $this->session->pid++;
	
    array_merge($repsone, self::check_queue($queue));
    echo json_encode($repsone);
	}
  private function check_queue($queue){
	$repsone=array();
    while(true){
      // Пытаемся найти ожидаемый PID
      $requestn=$queue->get($this->session->id, $this->session->pid);
      // Нету? Хуево! Уходим
      if($requestn===null) return $repsone;
      // Выполняем запрос
      $repsone[]=Request::a($requestn, $this->session->pid);
      // Ожидаемый запрос увеличиваем на 1
      $this->session->pid++;
    }
  }
  public function payment_callback(){
    $this->social->payment();
  }
}