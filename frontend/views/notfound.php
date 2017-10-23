<?php
namespace themes\php5to7\views;
use \packages\base;
use \packages\php5to7\views\notfound as notfoundView;
use \themes\php5to7\viewTrait;

class notfound extends notfoundView{
	use viewTrait;
	function __beforeLoad(){
		$this->setTitle("صفحه مورد نظر یافت نشد!");
	}
}
