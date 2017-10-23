<?php
namespace packages\php5to7\controllers;
use \packages\base\{controller, view, response};
use \packages\php5to7\views;
class homepage extends controller{
	public function index(){
		$response = new response();
		$view = view::byName(views\index::class);
		$response->setView($view);
		return $response;
	}
	public function contributing(){
		$response = new response();
		$view = view::byName(views\contributing::class);
		$response->setView($view);
		return $response;
	}
	public function donate(){
		$response = new response();
		$view = view::byName(views\donate::class);
		$response->setView($view);
		return $response;
	}
}