<?php
namespace themes\php5to7\views;
use \packages\base\translator;
use \themes\php5to7\utility;
use \themes\php5to7\viewTrait;
trait formTrait{
	protected $horizontal_form = false;
	protected $label_col;
	protected $input_col;
	public function setHorizontalForm($label_col, $input_col){
		$label_cols = explode(' ', $label_col);
		foreach($label_cols as $label_col){
			$this->label_col = 'col-'.$label_col;
		}
		$input_cols = explode(' ', $input_col);
		foreach($input_cols as $input_col){
			$this->input_col = 'col-'.$input_col;
		}
		$this->horizontal_form = true;
	}
	public function createField($options = array()){
		if(!isset($options['name'])){
			$options['name'] = '';
		}
		if(!isset($options['error']) or $options['error']){
			$error =  $this->getFormErrorsByInput($options['name']);
		}else{
			$error = false;
		}
		$code = '<div class="form-group'.($error ? ' has-error' : '').'">';
		if(isset($options['icon']) and $options['icon']){
			$code .= "<span class=\"input-icon\">";
		}
		if(isset($options['label']) and $options['label'])
			$code .= '<label class="control-label'.(($this->horizontal_form and $this->label_col) ? ' '.$this->label_col : '').'">'.$options['label'].'</label>';
		if(!isset($options['type'])){
			$options['type'] = 'text';
		}
		if(!isset($options['value'])){
			$options['value'] = $this->getDataForm($options['name']);
		}
		if(!isset($options['class'])){
			$options['class'] = $options['type'] != 'file' ? 'form-control' : '';
		}
		if($this->horizontal_form and $this->input_col){
			$code .= "<div class=\"{$this->input_col}\">";
		}
		if(in_array($options['type'], array('radio', 'checkbox'))){
			if(!isset($options['inline'])){
				$options['inline'] = false;
			}
			if(!isset($options['label'])){
				$options['label'] = true;
			}
			$code .= "<div>";
			foreach($options['options'] as $option){
				if($options['label']){
					$code .= '<label class="'.$options['type'].($options['inline'] ? '-inline' : '').'">';
				}
				$code .= "<input type=\"{$options['type']}\" name=\"{$options['name']}\" value=\"{$option['value']}\"";
				if(isset($option['class']) and $option['class']){
					$code .= " class=\"{$option['class']}\"";
				}
				if($option['value'] == $options['value']){
					$code .= " checked";
				}
				$code .= ">";
				if(isset($option['label']))$code .= $option['label'];
				$code .= '</label>';
			}
		}elseif($options['type'] == 'select'){
			$code .= "<select";
		}elseif($options['type'] == 'textarea'){
			$code .= "<textarea";
			if(isset($options['rows'])){
				$code.= " rows=\"{$options['rows']}\"";
			}
		}else{
			$code .= "<input type=\"{$options['type']}\" value=\"{$options['value']}\" ";
		}
		if(isset($options['id'])){
			$code .= " id=\"{$options['id']}\"";
		}
		if(!in_array($options['type'], array('radio', 'checkbox'))){
			$code .= " name=\"{$options['name']}\"";
			if(isset($options['ltr']) and $options['ltr']){
				$options['class'] .= " ltr";
			}
			if($options['class']){
				$code .= " class=\"{$options['class']}\"";
			}
			if(isset($options['placeholder']) and $options['placeholder']){
				$code .= " placeholder=\"{$options['placeholder']}\"";
			}
			if(isset($options['disabled']) and $options['disabled']){
				$code .= " disabled=\"disabled\"";
			}
			if(isset($options['readonly']) and $options['readonly']){
				$code .= " readonly=\"readonly\"";
			}
			$code .= ">";
		}
		if($options['type'] == 'select'){
		 	$code .= utility::selectOptions($options['options'], $options['value']);
			$code .="</select>";
		}
		if(in_array($options['type'], array('radio', 'checkbox'))){
			$code .= "</div>";
		}
		if($options['type'] == 'textarea'){
			$code .= "{$options['value']}</textarea>";
		}
		if(isset($options['icon']) and $options['icon']){
			$code .= "<i class=\"{$options['icon']}\"></i>";
			$code .= "</span>";
		}
		if($error){
			$text = null;
			if(isset($options['error']) and is_array($options['error'])){
				foreach($options['error'] as $type => $value){
					if($type == $error->getCode()){
						if(substr($value, -strlen($error->getCode())) == $error->getCode()){
							$text = translator::trans($value);
						}else{
							$text = $value;
						}
						break;
					}
				}
			}
			if(!$text){
				$text = translator::trans("{$options['name']}.".$error->getCode());
			}
			if(!$text){
				$text = translator::trans($error->getCode());
			}
			if($text){
				$code .= "<span class=\"help-block\" id=\"{$options['name']}-error\">{$text}</span>";
			}
		}
		if($this->horizontal_form and $this->input_col){
			$code .= "</div>";
		}
		$code .= '</div>';
		echo $code;
	}
}
