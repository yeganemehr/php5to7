<?php
namespace packages\php5to7\processes;
use \packages\base\process;
use \packages\PhpParser\ParserFactory;
use \packages\PhpParser\NodeTraverser;
use \packages\PhpParser\PrettyPrinter;
use \packages\php5to7\ParentConnector;
use \packages\php5to7\IncompatibleFixer;
class migrate extends process{
	public function run(){
		$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);
		$traverserParentConnector = new NodeTraverser;
		$traverserParentConnector->addVisitor(new ParentConnector);

		$traverserIncompatibleFixer = new NodeTraverser;
		$traverserIncompatibleFixer->addVisitor(new IncompatibleFixer);

		$prettyPrinter = new PrettyPrinter\Standard;

		$code = file_get_contents("/home/aroseirani/webserver/inc/classes/giu.class.php");
		$stmts = $parser->parse('
		<?php

		echo call_user_method_array("salam", $ob, ["arg2"]);
		
		');
		$stmts = $traverserParentConnector->traverse($stmts);
		$stmts = $traverserIncompatibleFixer->traverse($stmts);

		$code = $prettyPrinter->prettyPrintFile($stmts);

		//print_r($stmts);
		var_dump($code);
		return true;
	}
}