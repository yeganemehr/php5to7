<?php
namespace themes\php5to7\views\donate;
use \packages\base;
use \packages\php5to7\views\donate\callback as callbackView;
use \themes\php5to7\viewTrait;

class callback extends callbackView{
	use viewTrait;
	function __beforeLoad(){
		$this->setTitle("حمایت مالی");
	}
}
