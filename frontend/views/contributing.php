<?php
namespace themes\php5to7\views;
use \packages\base;
use \packages\php5to7\views\contributing as contributingView;
use \themes\php5to7\viewTrait;

class contributing extends contributingView{
	use viewTrait;
	function __beforeLoad(){
		$this->setTitle("راهنمای مشارکت");
	}
}
