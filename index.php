<?php

use Tranzzo\Leaf;
use Tranzzo\Node;

require_once __DIR__ . './vendor/autoload.php';

$leafList = new Leaf(2, new Leaf(4, new Leaf(3, new Leaf(1))));

$tree = new Node($leafList, [new Node(), new Node(), new Node()]);
var_dump(json_encode($tree->getArray()));
$l = $tree->processW(3);

var_dump(json_encode($tree->getArray()));
