<?php
class Helper_Language{
	const ADMIN=0;
	const GAME=1;
	private $lang;
	function __construct($type=Helper_Language::GAME, $config=null){
		switch ($type) {
			case self::ADMIN:
				$this->lang=include PATH_TO_GAME.'/language.php';
				break;
			case self::GAME:
				if($config==null) throw new Exception('Config is null in game language class.');

				break;
		}
	}
	function __get($key) {
		return isset($this->lang[$key])?$this->lang[$key]:null;
	}

}
