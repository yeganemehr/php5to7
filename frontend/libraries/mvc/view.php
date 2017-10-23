<?php
namespace themes\php5to7;
use \packages\base\date;
use \packages\base\translator;
use \packages\base\view\error;
use \packages\php5to7\frontend;
use \packages\php5to7\authorization;
trait viewTrait{
	protected $bodyClasses = array('rtl');
	function the_header($template = ''){
		require_once(__DIR__.'/../../html/header'.($template ? '.'.$template : '').'.php');
	}
	function the_footer($template = ''){
		require_once(__DIR__.'/../../html/footer'.($template ? '.'.$template : '').'.php');
	}
	public function addBodyClass($class){
		$this->bodyClasses[] = $class;
	}
	public function removeBodyClass($class){
		if(($key = array_search($class, $this->bodyClasses)) !== false){
			unset($this->bodyClasses[$key]);
		}
	}
	protected function genBodyClasses(){
		return implode(' ', $this->bodyClasses);
	}
	protected function getErrorsHTML(){
		$code = '';
		foreach($this->getErrors() as $error){
			$alert = array(
				'type' => 'info',
				'txt' => translator::trans('error.'.$error->getCode()),
				'title' => ''
			);
			switch($error->getType()){
				case(error::FATAL):
					$alert['type'] = 'danger';
					$alert['title'] = translator::trans('error.'.error::FATAL.'.title');
					break;
				case(error::WARNING):
					$alert['type'] = 'warning';
					$alert['title'] = translator::trans('error.'.error::WARNING.'.title');
					break;
				case(error::NOTICE):
					$alert['type'] = 'info';
					$alert['title'] = translator::trans('error.'.error::INFO.'.title');
					break;
			}



			$code .= "<div class=\"alert alert-block alert-{$alert['type']}\">
			<button data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button>
			<h4 class=\"alert-heading\">";
			switch($alert['type']){
				case('danger'):$code.="<i class=\"fa fa-times-circle\"></i>";break;
				case('success'):$code.="<i class=\"fa fa-check-circle\"></i>";break;
				case('info'):$code.="<i class=\"fa fa-info-circle\"></i>";break;
				case('warning'):$code.="<i class=\"fa fa-exclamation-triangle\"></i>";break;
			}

			$code .= " {$alert['title']}</h4><p>{$alert['txt']}</p>";
			if(isset($alert['btns']) and count($alert['btns']) > 0){
				$code .= "<p>";
				foreach($alert['btns'] as $btn){
					$code .= "<a href=\"{$btn['link']}\" class=\"btn {$btn['type']}\">{$btn['txt']}</a>";
				}
				$code .= "</p>";
			}
			$code .= "</div>";
		}

		return $code;
	}
}
