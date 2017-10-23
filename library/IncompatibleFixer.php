<?php
namespace packages\php5to7;
use packages\PhpParser\Node;
use packages\PhpParser\NodeTraverser;
use packages\PhpParser\NodeVisitorAbstract;

class IncompatibleFixer extends NodeVisitorAbstract {
	protected $todos = array();
	public function beforeTraverse(array $nodes){
	}
	public function enterNode(Node $node) {
		$this->checkForSetExceptionHandler($node);
		if(($result = $this->checkForArrayPointers($node)) !== null){
			return $result;
		}
		if(($result = $this->checkForCallUserMethod($node)) !== null){
			return $result;
		}
		if(($result = $this->checkForMcryptFunctions($node)) !== null){
			return $result;
		}
	}
	public function leaveNode(Node $node) {
		if(($result = $this->checkForLists($node)) !== null){
			return $result;
		}
		if(($result = $this->checkForForeachs($node)) !== null){
			return $result;
		}
		if(($result = $this->checkForBreakOrContinue($node)) !== null){
			return $result;
		}
		if(($result = $this->checkForPHP4Cunstructors($node)) !== null){
			return $result;
		}
	}
	protected function checkForSetExceptionHandler(Node $node){
		if($node instanceof Node\Expr\FuncCall){
			if(
				$node->name->toString() == "set_exception_handler" and
				isset($node->args[0]) and
				(
					$node->args[0]->value instanceof Node\Scalar\String_
				)
			){
				$todos[] = array(
					'action' => 'remove-argument-typing',
					'target' => $node->args[0]->value->value
				);
			}
		}
	}
	protected function checkForLists(Node $node){
		if(
			$node instanceof Node\Expr\Assign and
			$node->var instanceof Node\Expr\List_
		){
			if(empty($node->var->items) or (count($node->var->items) == 1 and empty($node->var->items[0]))){
				if(
					!$node->expr instanceof Node\Expr\Variable and
					!$node->expr instanceof Node\Expr\Array_ and 
					!$node->expr instanceof Node\Expr\ArrayDimFetch
				){
					return $node->expr;
				}
				return NodeTraverser::REMOVE_NODE;
			}
			$needChange = false;
			if($node->expr instanceof Node\Scalar\String_ or $node->expr instanceof Node\Scalar\Encapsed){
				$node->expr = new Node\Expr\FuncCall(new Node\Name("str_split"), array(new Node\Arg($node->expr)));
				$needChange = true;
			}
			$hasEmpty = false;
			foreach($node->var->items as $item){
				if(empty($item)){
					$hasEmpty = true;
					break;
				}
			}
			if($hasEmpty){
				$newNodes = array();
				$cItems = count($node->var->items);
				$tmpVariable = null;
				for($x = 0;$x < $cItems;$x++){
					if(!empty($node->var->items[$x])){
						if($node->expr instanceof Node\Expr\Array_){
							$expr = $node->expr->items[$x]->value;
						}elseif($node->expr instanceof Node\Expr\FuncCall or $node->expr instanceof Node\Expr\StaticCall or $node->expr instanceof Node\Expr\MethodCall){
							if(!$tmpVariable){
								$tmpVariable = new Node\Expr\Variable("uniqueVariable".rand(0,100000));
								array_unshift($newNodes, new Node\Expr\Assign($tmpVariable, $node->expr));
							}
							$expr = new Node\Expr\ArrayDimFetch($tmpVariable, new Node\Scalar\LNumber($x));
						}else{
							$expr = new Node\Expr\ArrayDimFetch($node->expr, new Node\Scalar\LNumber($x));
						}
						if($expr){
							$newNodes[] = new Node\Expr\Assign($node->var->items[$x], $expr);
						}
					}
				}
				if($newNodes){
					return $newNodes;
				}
			}
			if($needChange){
				return $node;
			}
		}
		return null;
	}
	protected function checkForArrayPointers(Node $node){
		if(
			$node instanceof Node\Expr\FuncCall and
			in_array($node->name->toString(), array('current', 'next', 'key', 'pos', 'prev')) and
			$foreach = $this->findParent($node, Node\Stmt\Foreach_::class)
		){
			$func = $node->name->toString();
			
			$keysVariable = $foreach->hasAttribute('keysVariable') ?  $foreach->getAttribute('keysVariable') : new Node\Expr\Variable("uniqueVariable".rand(0,100000));
			$counterVariable = $foreach->hasAttribute('counterVariable') ?  $foreach->getAttribute('counterVariable') : new Node\Expr\Variable("uniqueVariable".rand(0,100000));
			$pointerVariable = $foreach->hasAttribute('pointerVariable') ?  $foreach->getAttribute('pointerVariable') : new Node\Expr\Variable("uniqueVariable".rand(0,100000));
			$newNode = null;
			if($func == 'current' or $func == 'pos'){
				$condition = new Node\Expr\Isset_([new Node\Expr\ArrayDimFetch($keysVariable, $pointerVariable)]);
				$if = new Node\Expr\ArrayDimFetch($foreach->expr, new Node\Expr\ArrayDimFetch($keysVariable, $pointerVariable));
				$else = new Node\Expr\ConstFetch(new Node\Name('false'));
				$newNode = new Node\Expr\Ternary($condition, $if, $else);
			}elseif($func == 'next'){
				$condition = new Node\Expr\Isset_([new Node\Expr\ArrayDimFetch($keysVariable, $pointerVariable), new Node\Expr\ArrayDimFetch($keysVariable, new Node\Expr\PreInc($pointerVariable))]);
				$if = new Node\Expr\ArrayDimFetch($foreach->expr, new Node\Expr\ArrayDimFetch($keysVariable, $pointerVariable));
				$else = new Node\Expr\ConstFetch(new Node\Name('false'));
				$newNode = new Node\Expr\Ternary($condition, $if, $else);
			}elseif($func == 'prev'){
				$condition = new Node\Expr\Isset_([new Node\Expr\ArrayDimFetch($keysVariable, $pointerVariable), new Node\Expr\ArrayDimFetch($keysVariable, new Node\Expr\PreDec($pointerVariable))]);
				$if = new Node\Expr\ArrayDimFetch($foreach->expr, new Node\Expr\ArrayDimFetch($keysVariable, $pointerVariable));
				$else = new Node\Expr\ConstFetch(new Node\Name('false'));
				$newNode = new Node\Expr\Ternary($condition, $if, $else);
			}elseif($func == 'key'){
				$newNode = new Node\Expr\ArrayDimFetch($keysVariable, $pointerVariable);
			}
			if($newNode){
				$newNode->setAttribute('php5to7-differ-change', array(
					'type' => 'change-expr',
					'from' => $func.'()'
				));
				if(!$foreach->hasAttribute('keysVariable')){
					$keysVariable->setAttribute('php5to7-differ-change', true);
					$foreach->setAttribute('keysVariable', $keysVariable);
				}
				if(!$foreach->hasAttribute('counterVariable')){
					$counterVariable->setAttribute('php5to7-differ-change', array(
						'type' => 'new-variable'
					));
					$foreach->setAttribute('counterVariable', $counterVariable);
				}
				if(!$foreach->hasAttribute('pointerVariable')){
					$pointerVariable->setAttribute('php5to7-differ-change',array(
						'type' => 'new-variable'
					));
					$foreach->setAttribute('pointerVariable', $pointerVariable);
				}
				return $newNode;
			}
		}
	}
	protected function findParent(Node $node, $class){
		if(get_class($node) == $class){
			return $node;
		}elseif($parent = $node->getAttribute('parent')){
			return $this->findParent($parent, $class);
		}
		return null;
	}
	protected function checkForForeachs(Node $node){
		if($node instanceof Node\Stmt\Foreach_){
			$newNode = [$node];
			if($node->hasAttribute('keysVariable')){
				array_unshift($newNode, new Node\Expr\Assign($node->getAttribute('keysVariable'), new Node\Expr\FuncCall(new Node\Name('array_keys'),  [new Node\Arg($node->expr)])));
			}
			if($node->hasAttribute('counterVariable')){
				array_unshift($newNode, new Node\Expr\Assign($node->getAttribute('counterVariable'),new Node\Scalar\LNumber(0)));
			}
			if($node->hasAttribute('pointerVariable')){
				array_unshift($node->stmts, new Node\Expr\Assign($node->getAttribute('pointerVariable'), new Node\Expr\PreInc($node->getAttribute('counterVariable'))));
			}
			return $newNode;
		}
	}
	protected function checkForBreakOrContinue(Node $node){
		if(
			($node instanceof Node\Stmt\Continue_ or $node instanceof Node\Stmt\Break_) and
			!$this->findParent($node, Node\Stmt\Foreach_::class) and
			!$this->findParent($node, Node\Stmt\For_::class) and
			!$this->findParent($node, Node\Stmt\While_::class) and
			!$this->findParent($node, Node\Stmt\Switch_::class)
		){
			$newNode = new Node\Stmt\Return_();
			$newNode->setAttribute('php5to7-differ-change',array(
				'type' => 'change-keyword',
				'from' => $node instanceof Node\Stmt\Continue_ ? 'continue' : 'break',
				'to' => 'return'
			));
			return $newNode;
		}
	}
	protected function checkForCallUserMethod(Node $node){
		if(
			$node instanceof Node\Expr\FuncCall and
			($node->name->toString() == "call_user_method" or $node->name->toString() == "call_user_method_array")
		){
			$args = array(
				new Node\Arg(new Node\Expr\Array_([new Node\Expr\ArrayItem($node->args[1]->value), new Node\Expr\ArrayItem($node->args[0]->value)]))
			);
			$argsCount = count($node->args);
			for($x = 2;$x < $argsCount;$x++){
				$args[] = $node->args[$x];
			}
			$newNode = new Node\Expr\FuncCall(new Node\Name('call_user_func'.substr($node->name->toString(), 16)), $args);
			$newNode->setAttribute('php5to7-differ-change', array(
				'type' => 'change-function-name',
				'from' => $node->name->toString(),
				'to' => 'call_user_func'.substr($node->name->toString(), 16)
			));
			return $newNode;
		}
	}
	protected function checkForMcryptFunctions(Node $node){
		if($node instanceof Node\Expr\FuncCall and $node->name->toString() == "mcrypt_generic_end"){
			$node->name = new Node\Name('mcrypt_generic_deinit');
			$node->setAttribute('php5to7-differ-change', array(
				'type' => 'change-function-name',
				'from' => 'mcrypt_generic_end',
				'to' => 'mcrypt_generic_deinit'
			));
		}
	}
	protected function checkForPHP4Cunstructors(Node $node){
		if(
			$node instanceof Node\Stmt\ClassMethod and
			$class = $this->findParent($node, Node\Stmt\Class_::class) and
			$node->name == $class->name
		){
			$node->name = '__construct';
			$node->setAttribute('php5to7-differ-change', array(
				'type' => 'change-method-name',
				'from' => $class->name,
				'to' => '__construct'
			));
		}
	}
}