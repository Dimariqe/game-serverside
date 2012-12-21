<?php
define('PATH_TO_GAME', __DIR__);
spl_autoload_register(function ($class) {
	$class_path=str_replace('_', '/', strtolower($class)).'.php';
	if(is_readable(PATH_TO_GAME.'/'.$class_path))
		require_once PATH_TO_GAME.'/'.$class_path;
	else throw new Exception('Class '.$class.' not found.');
});