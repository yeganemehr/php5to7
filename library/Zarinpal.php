<?php
namespace packages\php5to7;
use \packages\base\packages;

class Zarinpal{
	private $merchantID;
	public function __construct(){
		$this->merchantID = packages::package('php5to7')->getOption('zarinpal.merchantid');
		if(!$this->merchantID){
			throw new MerchantException;
		}
	}
	public function paymentRequest(int $amount, string $description, string $callback){
		$data = json_encode(array(
			'MerchantID' => $this->merchantID,
			'Amount' => $amount,
			'CallbackURL' => $callback,
			'Description' => $description
		));
		$ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
		curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data)
		));
		$result = curl_exec($ch);
		$err = curl_error($ch);
		$result = json_decode($result);
		curl_close($ch);
		if ($result->Status != 100) {
			throw new RequestStatusException($result->Status);
		}
		return "https://zarinpal.com/pg/StartPay/{$result->Authority}";
	}
	public function paymentVerification(int $amount, string $authority){
		$data = json_encode(array(
			'MerchantID' => $this->merchantID,
			'Amount' => $amount,
			'Authority' => $authority
		));
		$ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
		curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data)
		));
		$result = curl_exec($ch);
		$err = curl_error($ch);
		$result = json_decode($result);
		curl_close($ch);
		if ($result->Status == 100 or $result->Status == 101) {
			return true;
		}
		if(in_array($result->Status, [-21, -22, -33])){
			return false;
		}
		throw new RequestStatusException($result->Status);
	}
}