<?php
namespace packages\php5to7;
class RequestStatusException extends \Exception{
	protected $status;
	public function __construct(int $status = 0){
		$this->status = $status;
		parent::__construct("Zarinpal return request with this status: {$status}");
	}
	public function getStatus(){
		return $this->status;
	}
}