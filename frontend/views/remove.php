<?php
namespace themes\php5to7\views;
use \packages\base;
use \packages\php5to7\views\remove as removeView;
use \themes\php5to7\viewTrait;

class remove extends removeView{
	use viewTrait;
	function __beforeLoad(){
		$this->setTitle("ابزار مهاجرت به php 7");
	}
}
