<?php
class Social_FB {
	private $auth=false;
	private $user=false;
	private $uid=0;
	private $session=null;

	public function __construct($config, $session) {
		$this->config=$config;
		$this->session=$session;

		// Loading
		$this->auth=$this->session->auth;
		$this->user=$this->session->user;
		$this->uid=$this->user!=null?$this->user['user_id']:null;

		if($this->auth==true) { return; }
		// Checked request
		if(!isset($_REQUEST['signed_request']))
			throw new Exception('FB: Request param signed_request do not exist.');
		$this->user=Helper_FBHash::parse_signed_request(
			$_REQUEST['signed_request'],
			$config['social']['fb']['key']
		);
		// Checked authorization
		if(isset($this->user['user_id'])) {
			$this->auth=true;
			$this->uid=$this->user['user_id'];
		}
	}

	function __destruct() {
		$this->session->auth=$this->auth;
    $this->session->user=$this->user;
	}
  public function show_iframe($additional){
    $additional=array_merge($additional, array(
      'locale'=>$this->get_locale(),
      'social'=>$this->get_social(),
      'uid'=>$this->get_uid(),
      'appid'=>$this->config['social']['fb']['id'],
      'config'=>$this->config['social']['fb'],
      'token'=>$this->get_token(),
      'http_scheme'=>$_SERVER["SERVER_PORT"] == 443 ? "https" : "http",
    ));
    $template=new View($additional);
    if($this->check())
      echo $template->display($this->get_social().'.index');
    else
      echo $template->display($this->get_social().'.index.preloader');
  }
  public function payment(){
    $pdo=new PDO('mysql:host='.
        $this->config['database']['admin']['host'].';dbname='.$this->config['database']['admin']['database'],
      $this->config['database']['admin']['user'],
      $this->config['database']['admin']['password']);

    $method = $_REQUEST['method'];
    $repsone=array();
    $credits=$this->user['credits'];
    $order_details=isset($credits['order_info'])?json_decode($credits['order_info']):null;

    // при получении фейсбуковский order_id преобразуется из строки во float и это скорее всего может стать
    // огромной проблемой (потеряется пара последних знаков в номере заказа, который нам возвращает FB).
    // Выдернем его руками
    $payloadData = explode('.', $_REQUEST['signed_request'], 2);
    $payloadData = Helper_FBHash::base64_url_decode($payloadData[1]);
    preg_match('/\"order_id\"\:([0-9]*)/', $payloadData, $matches);
    $extOrderId = $matches[1];

    if (!empty($order_details) && isset($order_details->order_id)) {
      $orderId = (int)$order_details->order_id;
    }
    if (empty($orderId)) {
      // Повторный запрос (оплата прошла), в нем нашего внутреннего order_id уже нет.
      // Надо взять заказ по фейсбуковскому order_id
      $order=$pdo->prepare('SELECT * FROM payments WHERE extid=:extid');
      $order->execute(array(
        ':extid'=>$extOrderId
      ));
      $order=$order->fetch();
      $orderId=$order['oid'];
    }
    $itemInfo=new Object_Payment($this->config, 'fb');

    if (!empty($order) && $order['status']>0) {
      // Заказ уже был оплачен
      $repsone['content']['status'] = 'settled';

    } elseif ($method == 'payments_status_update') {
      if ($credits['status'] == 'placed') {
        $repsone['content']['status'] = 'settled';

        // Заказ оплачен! Отдаем юзеру его ресурсы!
        $order_save=$pdo->prepare('UPDATE payments SET status=:status WHERE extid=:extid');
        $order_save->execute(array(
          ':extid'=>$extOrderId,
          ':status'=>1
        ));
      }
      // compose returning data array_change_key_case
      $repsone['content']['order_id'] = $orderId;

    } elseif($method=='payments_get_items'){
      $item = $itemInfo->get((int)$orderId);
      if($item){
        $item['title']   = $order_details->title;
        $item['description']   = $order_details->description;
        $item['image_url']   = $order_details->image_url;
        $item['product_url'] = $order_details->product_url;
        $item['order_id'] = $orderId;
        $order_save=$pdo->prepare('INSERT INTO payments (status, oid, extid) VALUES (:status, :oid, :extid)');
        $order_save->execute(array(
          ':oid'=>$orderId,
          ':extid'=>$extOrderId,
          ':status'=>0
        ));
      } else $repsone['content']['status'] = 'canceled';
      $repsone['content']=array($item);
    }
    $repsone['method']=$method;
    echo json_encode($repsone);
  }
	public function check()			{ return $this->auth; }
	public function get_uid()		{ return $this->uid;	}
	public function get_locale(){ return $this->user['user']['locale'];	}
	public function get_social(){	return 'FB'; }
  public function get_token(){ return $this->user['oauth_token']; }
}