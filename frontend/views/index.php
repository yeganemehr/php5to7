<?php
namespace themes\php5to7\views;
use \packages\base;
use \packages\php5to7\views\index as indexView;
use \themes\php5to7\viewTrait;

class index extends indexView{
	use viewTrait;
	function __beforeLoad(){
		$this->setTitle("ابزار مهاجرت به php 7");
	}
}
