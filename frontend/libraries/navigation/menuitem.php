<?php
namespace themes\easybpm\navigation;
use themes\easybpm\breadcrumb;
use \packages\base\http;
class menuItem{
	private $name;
	private $title;
	private $url;
	private $icon;
	private $priority;
	private $active;
	function __construct($name){
		$this->name = $name;
	}
	function setTitle($title){
		$this->title = $title;
	}
	function getTitle(){
		return $this->title;
	}
	function setURL($url){
		$this->url = $url;
	}
	function getURL(){
		return $this->url;
	}
	function setIcon($icon){
		$this->icon = $icon;
	}
	function getIcon(){
		return $this->icon;
	}
	function setPriority($priority){
		$this->priority = $priority;
	}
	function getPriority(){
		return $this->priority;
	}
	function getName(){
		return $this->name;
	}
	function active($active){
		$this->active = is_string($active) ? explode("/", $active, 2) : $active;
	}
	function build(){
		$thisuri = http::$request['uri'];
		//$active = (substr($thisuri, 0, strlen($this->url)) == $this->url);
		$active = (bool)$this->active;
		$html = "<a class=\"list-group-item";
		if($active){
			if($active)$html .=' active';
		}
		$html .="\" href=\"{$this->url}\">".($this->icon ? "<i class=\"{$this->icon}\"></i>" : "")."<span class=\"title\"> {$this->title}</span></a>";
		return $html;
	}
}
