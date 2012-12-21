<?php
class View {
	//Массив с переменными для шаблона
	private $_arr;
	//Где лежать Viewer'ы
	private $dir;
	//Вызвать рендеринг, если не вызвана функция display() в destruct
	private $autorender;
	//Имя Viewer'а
	private $tpl;

	public function __construct($arr=array(), $tpl=null, $autorender=false) {
		$this->dir=PATH_TO_GAME.'/view/';
		$this->_arr=$arr;
		$this->autorender=$autorender;
		$this->tpl=$tpl;
	}
	public function __set($var, $name) {
		$this->_arr[$var] = $name;
	}
	public function __destruct(){
		if($this->autorender==true)
			echo self::display();
	}
	public static function factory($arr=array(), $tpl=null, $autorender=false){
		return new self($arr, $tpl, $autorender);
	}
	public function display($tpl=false) {
		//Ищем указан ли у нас Viewer
		if(!$tpl && $this->tpl!=null) $tpl=$this->tpl;
		else if(!$tpl) throw new Exception('Viewer is not defined.');
		//Доступена ли дерриктория для записи?
		if (is_readable(strtolower($this->dir.$tpl).'.php')) {
			//Извлекаем переменные из массива
			extract($this->_arr, EXTR_SKIP);
			//Создаем буфер
			ob_start();
			//Вставляе Viewer
			include strtolower($this->dir.$tpl).'.php';
			//Записываем буфер
			$contents = ob_get_contents();
			//Чистим буфер
			ob_end_clean();
			$this->autorender=false;
			return $contents;
		} else {
			throw new Exception('Viewer '.$tpl.' not found.');
		}
	}
}