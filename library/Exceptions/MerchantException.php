<?php
namespace packages\php5to7;
class MerchantException extends \Exception{
	public function __construct(){
		parent::__construct("Zarinpal merchant code is empty");
	}
}