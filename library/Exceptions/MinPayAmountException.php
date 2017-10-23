<?php
namespace packages\php5to7;
class MinPayAmountException extends \Exception{
	protected $minAmount;
	public function __contruct(int $minAmount){
		$this->minAmount = $minAmount;
	}
	public function getMinAmount(){
		return $this->minAmount;
	}
}