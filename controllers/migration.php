<?php
namespace packages\php5to7\controllers;
use \packages\base;
use \packages\base\{controller, view, packages, response, inputValidation, views\FormError, view\error, NotFound};
use \packages\base\IO\{file\local as file, directory\local as directory};
use \packages\PhpParser\{ParserFactory, NodeTraverser};
use \packages\php5to7\{views, ParentConnector, IncompatibleFixer, UploadException, PrettyPrinter};

class migration extends controller{
	public function upload(){
		$response = new response();
		$view = view::byName(views\index::class);
		$response->setStatus(false);
		try{
			$inputs = $this->checkinputs(array(
				'file' => array(
					'type' => 'file'
				)
			));
			if(isset($inputs['file']['error'])){
				$inputs['file'] = [$inputs['file']];
			}
			foreach($inputs['file'] as $uploadedFile){
				$md5 = (new file($uploadedFile['tmp_name']))->md5();
				$storage = new directory(packages::package('php5to7')->getFilePath('storage/private'));
				if(!$storage->exists()){
					$storage->make(true);
				}
				$file = $storage->file($md5);
				if(!move_uploaded_file($uploadedFile['tmp_name'], $file->getPath())){
					throw new UploadException();
				}
				
				$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);
				$traverserParentConnector = new NodeTraverser;
				$traverserParentConnector->addVisitor(new ParentConnector);

				$traverserIncompatibleFixer = new NodeTraverser;
				$traverserIncompatibleFixer->addVisitor(new IncompatibleFixer);

				$prettyPrinter = new PrettyPrinter;

				$stmts = $parser->parse($file->read());
				$stmts = $traverserParentConnector->traverse($stmts);
				$stmts = $traverserIncompatibleFixer->traverse($stmts);

				$code = $prettyPrinter->prettyPrintFile($stmts);
				$file->write($code);
				$file->rename($file->md5());
				$view->addFile($file, $uploadedFile['name'], $prettyPrinter->changes);
			}
		$response->setStatus(true);
		}catch(inputValidation $e){

		}

		$response->setView($view);
		return $response;
	}
	public function download($data){
		$storage = new directory(packages::package('php5to7')->getFilePath('storage/private'));
		$file = $storage->file($data['md5']);
		if(!$file->exists()){
			throw new NotFound();
		}

		$responseFile = new response\file();
		$responseFile->setLocation($file->getPath());
		$responseFile->setSize($file->size());
		$responseFile->setMimeType('text/plain');
		$responseFile->setName($file->basename.'.php');
		$responseFile->setForceDownload(true);
		$response = new response();
		$response->setFile($responseFile);
		return $response;
	}
	public function raw($data){
		$storage = new directory(packages::package('php5to7')->getFilePath('storage/private'));
		$file = $storage->file($data['md5']);
		if(!$file->exists()){
			throw new NotFound();
		}

		$responseFile = new response\file();
		$responseFile->setLocation($file->getPath());
		$responseFile->setSize($file->size());
		$responseFile->setMimeType('text/plain');
		$responseFile->setName($file->basename.'.php');
		$response = new response();
		$response->setFile($responseFile);
		return $response;
	}
	public function remove($data){
		
		$storage = new directory(packages::package('php5to7')->getFilePath('storage/private'));
		$file = $storage->file($data['md5']);
		if(!$file->exists()){
			throw new NotFound();
		}
		$response = new response();
		//$file->delete();
		$view = view::byName(views\remove::class);
		$response->setStatus(true);
		$response->setView($view);
		return $response;
	}
}