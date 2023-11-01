<?php

namespace App\Classes\Tree;

class TreeNode
{
    public mixed $key;
    public mixed $data;
    public mixed $left;
    public mixed $right;

    public function __construct($key, $data) {
        $this->key = $key;
        $this->data = $data;
        $this->left = null;
        $this->right = null;
    }
}
