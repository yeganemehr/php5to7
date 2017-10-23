<?php
namespace themes\easybpm\views;
use \packages\base\http;
use \packages\base\translator;
use \themes\easybpm\viewTrait;
trait listTrait{
	private $buttons = array();
	public function setButton($name, $active, $params = array()){
		if(!isset($params['classes'])){
			$params['classes'] = array('btn', 'btn-xs', 'btn-default');
		}
		if(isset($params['title']) and $params['title']){
			$params['classes'][] = 'tooltips';
		}
		if(!isset($params['link'])){
			$params['link'] = '#';
		}
		$button = array(
			'active' => $active,
			'params' => $params
		);
		$this->buttons[$name] = $button;
	}
	public function setButtonActive($name, $active){
		if(isset($this->buttons[$name])){
			$this->buttons[$name]['active'] = $active;
			return true;
		}
		return false;
	}
	public function setButtonParam($name, $parameter, $value){
		if(isset($this->buttons[$name])){
			$this->buttons[$name]['params'][$parameter] = $value;
			return true;
		}
		return false;
	}
	public function unsetButtonParam($name, $parameter){
		if(isset($this->buttons[$name])){
			unset($this->buttons[$name]['params'][$parameter]);
			return true;
		}
		return false;
	}
	public function hasButtons(){
		$have = false;
		foreach($this->buttons as $btn){
			if($btn['active']){
				$have = true;
				break;
			}
		}
		return $have;
	}
	public function genButtons($responsive = true){
		$buttons = array();
		foreach($this->buttons as $name => $btn){
			if($btn['active']){
				$buttons[$name] = $btn;
			}
		}
		$code = '';
		if($buttons){
			if($responsive and count($buttons) > 1){
				$code .= '<div class="visible-md visible-lg hidden-sm hidden-xs">';
			}
			foreach($buttons as $btn){
				$code .= '<a';
				if(isset($btn['params']['link']) and $btn['params']['link']){
					$code .= ' href="'.$btn['params']['link'].'"';
				}
				if(isset($btn['params']['classes']) and $btn['params']['classes']){
					if(is_array($btn['params']['classes'])){
						$btn['params']['classes'] = implode(" ", $btn['params']['classes']);
					}
					$code .= ' class="'.$btn['params']['classes'].'"';
				}
				if(isset($btn['params']['data']) and $btn['params']['data']){
					foreach($btn['params']['data'] as $name => $value){
						$code .= ' data-'.$name.'="'.$value.'"';
					}
				}
				if(isset($btn['params']['title']) and $btn['params']['title']){
					$code .= ' title="'.$btn['params']['title'].'"';
				}
				$code .= '>';
				if(isset($btn['params']['icon']) and $btn['params']['icon']){
					$code .= '<i class="'.$btn['params']['icon'].'"></i>';
				}
				$code .= '</a> ';
			}
			if($responsive and count($buttons) > 1){
				$code .= '</div>';
				$code .= '<div class="visible-xs visible-sm hidden-md hidden-lg">';
				$code .= '<div class="btn-group">';
				$code .= '<a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <span class="caret"></span></a>';
				$code .= '<ul role="menu" class="dropdown-menu pull-right">';
				foreach($buttons as $btn){
					$code .= '<li><a tabindex="-1"';
					if(isset($btn['params']['link']) and $btn['params']['link']){
						$code .= ' href="'.$btn['params']['link'].'"';
					}
					if(isset($btn['data']) and $btn['params']['data']){
						foreach($btn['params']['data'] as $name => $value){
							$code .= ' data-'.$name.'="'.$value.'"';
						}
					}
					$code .= '>';
					if(isset($btn['params']['icon']) and $btn['params']['icon']){
						$code .= '<i class="'.$btn['params']['icon'].'"></i>';
					}
					if(isset($btn['params']['title']) and $btn['params']['title']){
						$code .= ' '.$btn['params']['title'];
					}
					$code .= '</a></li>';
				}
				$code .= '</ul></div></div>';
			}
		}


		return $code;
	}
	public function paginator($selectbox = false, $mid_range = 7){
		$return = "<hr><ol class=\"pagination text-center pull-left hidden-xs\">";
		$prev_page = $this->currentPage-1;
        $next_page = $this->currentPage+1;

		if($this->currentPage != 1 and $this->totalItems >= 10){
			$return .= "<li class=\"prev\"><a href=\"".$this->pageurl($prev_page)."\">".translator::trans('pagination.previousPage')."</a></li>";
		}else{
			$return .= "<li class=\"prev disabled\"><a>".translator::trans('pagination.previousPage')."</a></li>";
		}
		$start_range = $this->currentPage - floor($mid_range/2);
		$end_range = $this->currentPage + floor($mid_range/2);

		if($start_range <= 0){
			$end_range += abs($start_range)+1;
			$start_range = 1;
		}

		if($end_range > $this->totalPages){
			$start_range -= $end_range-$this->totalPages;
			$end_range = $this->totalPages;
		}

		$range = range($start_range,$end_range);

		for($i=1;$i <= $this->totalPages;$i++){
			if($range[0] > 2 and $i == $range[0]){
				$return .= "<li><a> ... </a></li>";
			}
			// loop through all pages. if first, last, or in range, display
			if($i == 1 or $i == $this->totalPages or in_array($i,$range)){
				if($i == $this->currentPage){
					$return .= "<li class=\"active\"><a href=\"#\">{$i}</a></li>";
				}else{
					$return .= "<li><a href=\"".$this->pageurl($i)."\">{$i}</a></li>";
				}
			}
			if($range[$mid_range - 1] < $this->totalPages - 1 and $i == $range[$mid_range - 1]){
				$return .= "<li><a> ... </a></li>";
			}
		}
		if($this->currentPage != $this->totalPages and $this->totalItems >= 10){
			$return .= "<li class=\"next\"><a href=\"".$this->pageurl($next_page)."\">".translator::trans('pagination.nextPage')."</a></li>";
		}else{
			$return .= "<li class=\"next disabled\"><a>".translator::trans('pagination.nextPage')."</a></li>";
		}
		$return .= "</ol>";
		$return .= "<div class=\"visible-xs\">";
		$return .= "<span class=\"paginate\">".translator::trans('pagination.page').": </span>";
		$return .= "<select class=\"paginate\">";
        for($i = 1;$i <= $this->totalPages;$i++){
            $return .= "<option value=\"{$i}\" data-url=\"".$this->pageurl($i)."\"".($i == $this->currentPage ? ' selected' : '').">{$i}</option>";
        }
		$return .= "</select>";
		echo $return;
	}
	private function pageurl($page, $ipp = null){
		if($ipp === null){
			$ipp = $this->itemsPage;
		}
		if($ipp == 25){
			$ipp = null;
		}
		$paginationData = http::$request['get'];
		if($page != 1){
			$paginationData['page'] = $page;
		}else{
			unset($paginationData['page']);
		}
		if($ipp){
			$paginationData['ipp'] = $ipp;
		}else{
			unset($paginationData['ipp']);
		}
		return($paginationData ? '?'.http_build_query($paginationData) : http::$request['uri']);
	}
}
