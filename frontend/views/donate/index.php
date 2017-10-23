<?php
namespace themes\php5to7\views\donate;
use \packages\base;
use \packages\php5to7\views\donate\index as indexView;
use \themes\php5to7\viewTrait;
use \themes\php5to7\views\formTrait;

class index extends indexView{
	use viewTrait, formTrait;
	function __beforeLoad(){
		$this->setTitle("حمایت مالی");
	}
}
