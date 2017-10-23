<?php
namespace packages\php5to7\views\donate;
use \packages\base\view;
class callback extends view{
	public function setPayStatus(bool $status){
		$this->setData($status, 'paystatus');
	}
	public function getPayStatus():bool{
		return $this->getData('paystatus');
	}
}