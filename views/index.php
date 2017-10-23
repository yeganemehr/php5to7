<?php
namespace packages\php5to7\views;
use \packages\base\view;
use \packages\base\IO\file\local as file;
class index extends view{
	public function addFile(file $file, string $name, array $changes){
		$files = $this->getFiles();
		$files[] = array(
			'file' => $file,
			'name' => $name,
			'changes' => $changes
		);
		$this->setData($files, 'files');
	}
	public function getFiles():array{
		$files = $this->getData('files');
		return is_array($files) ? $files : [];
	}
	public function export(){
		$files = [];
		foreach($this->getFiles() as $file){
			$files[] = array(
				'name' => $file['name'],
				'md5' => $file['file']->md5(),
				'content' => $file['file']->read(),
				'changes' => $file['changes']
			);
		}
		return array(
			'data' => array(
				'files' => $files
			)
		);
	}
}