<?php

namespace packages\php5to7;

use packages\base\json;
use packages\PhpParser\Node;
use packages\PhpParser\PrettyPrinter\Standard;

class PrettyPrinter extends Standard
{
    public $changes = [];
     /**
     * Pretty prints a file of statements (includes the opening <?php tag if it is required).
     *
     * @param Node[] $stmts Array of statements
     *
     * @return string Pretty printed statements
     */
    public function prettyPrintFile(array $stmts) {
        $result = parent::prettyPrintFile($stmts);
        $finalResult = "";
        $lines = explode("\n", $result);
        foreach($lines as $number => $line){
            $offset = 0;
            $token = "**php5to7-differ-change**";
            while(($pos = strpos($line, $token, $offset)) !== false){
                $afterToken = $pos + strlen($token);
                $comma = strpos($line, ',', $afterToken);
                $len = substr($line, $afterToken, $comma - $afterToken);
                $json = substr($line, $comma + 1, intval($len));
                $json = json\decode($json);
                $json['line'] = $number + 1;
                $this->changes[] = $json;
                $line = substr($line, 0, $pos).substr($line, $comma + intval($len) + 1 );
            }
            $finalResult .= $line."\n";
        }
        return $finalResult;
    }
    /**
     * Pretty prints a node.
     *
     * @param Node $node Node to be pretty printed
     *
     * @return string Pretty printed node
     */
    protected function p(Node $node) {
        $result = parent::p($node);
        if($change = $node->getAttribute('php5to7-differ-change')){
            $jsonData = json\encode($change);
            $result = "**php5to7-differ-change**".strlen($jsonData).",".$jsonData.$result;
        }
        return $result;
    }
}
