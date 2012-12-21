<?php
class Request {
	static public function a($request, $aaa){
    switch ($request->Type){
      case 'CLIENT_PING':
        return array('Type'=>'SERVER_PING', 'Message'=>$request->Message, 'RPID'=>$aaa);
        break;
    }
	}
}