<?php
namespace packages\php5to7;
use packages\PhpParser\Node;
use packages\PhpParser\NodeVisitorAbstract;

class ParentConnector extends NodeVisitorAbstract {
	private $stack;
	public function beforeTraverse(array $nodes) {
		$this->stack = [];
	}
	public function enterNode(Node $node) {
		if (!empty($this->stack)) {
			$node->setAttribute('parent', $this->stack[count($this->stack)-1]);
		}
		$this->stack[] = $node;
	}
	public function leaveNode(Node $node) {
		array_pop($this->stack);
	}
}