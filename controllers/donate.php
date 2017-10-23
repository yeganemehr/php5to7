<?php
namespace packages\php5to7\controllers;
use \packages\base;
use \packages\base\{controller, view, http, response, inputValidation, views\FormError, view\error};
use \packages\php5to7\{views, Zarinpal, MinPayAmountException, RequestStatusException, MerchantException};

class donate extends controller{
	public function index(){
		$response = new response();
		$view = view::byName(views\donate\index::class);
		$response->setView($view);
		return $response;
	}
	public function toPayport(){
		$response = new response();
		$view = view::byName(views\donate\index::class);
		$response->setView($view);
		$inputRules = array(
			'amount' => array(
				'type' => 'number',
			),
			'currency' => array(
				'values' => ['Toman', 'BTC']
			)
		);
		$response->setStatus(false);
		try{
			$inputs = $this->checkinputs($inputRules);
			if($inputs['currency'] == 'Toman'){
				if($inputs['amount'] <= 100){
					throw new MinPayAmountException(100);
				}
			}
			if($inputs['currency'] == 'Toman'){
				$zp = new Zarinpal();
				$request = $zp->paymentRequest($inputs['amount'], "کمک مالی", base\url('donate/callback', ['amount' => $inputs['amount']], true));
				$response->setStatus(true);
				$response->Go($request);
			}
		}catch(inputValidation $error){
			$view->setFormError(FormError::fromException($error));
		}catch(MinPayAmountException $e){
			$error = new error();
			$error->setCode('Zarinpal.MinPayAmountException');
			$error->setData($e->getMinAmount(), 'minAmount');
			$view->addError($error);
		}catch(RequestStatusException $e){
			$error = new error();
			$error->setCode('Zarinpal.RequestStatusException');
			$view->addError($error);
		}catch(MerchantException $e){
			$error = new error();
			$error->setCode('Zarinpal.MerchantException');
			$view->addError($error);
		}
		return $response;
	}
	public function callback(){
		$response = new response();
		$view = view::byName(views\donate\callback::class);
		$response->setView($view);
		$view->setPayStatus(false);
		try{
			if(http::getData('amount') and http::getData('Authority') and http::getData('Status') == 'OK'){
				$zp = new Zarinpal();
				$request = $zp->paymentVerification(http::getData('amount'), http::getData('Authority'));
				$view->setPayStatus($request);
			}
		}catch(RequestStatusException $e){
			$error = new error();
			$error->setCode('Zarinpal.RequestStatusException');
			$view->addError($error);
		}catch(MerchantException $e){
			$error = new error();
			$error->setCode('Zarinpal.MerchantException');
			$view->addError($error);
		}
		return $response;
	}
}