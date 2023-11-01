<?php

namespace App\Classes\Tree;

class BinarySearchTree
{
    private TreeNode|null $root = null;

    private int $comparesCount = 0;
    private array $findDocuments = [];

    public function insert($key, $data): void
    {
        $newNode = new TreeNode($key, $data);
        if ($this->root === null) {
            $this->root = $newNode;
        } else {
            $this->insertNode($this->root, $newNode);
        }
    }

    private function insertNode(&$node, &$newNode): void
    {
        if ($node === null) {
            $node = $newNode;
        } else {
            if ($newNode->key < $node->key) {
                $this->insertNode($node->left, $newNode);
            } else {
                $this->insertNode($node->right, $newNode);
            }
        }
    }

    public function search($value, $withIndex = true): array
    {
        $this->comparesCount = 0;
        $this->findDocuments = [];

        if ($withIndex) {
           $this->searchNodesWithIndex($this->root, $value);
        } else {
            $this->searchNodesWithoutIndex($this->root, $value);
        }

        return [
            'documents' => $this->findDocuments,
            'comparisons' => $this->comparesCount,
            'documents_count' => count($this->findDocuments),
        ];
    }

    private function searchNodesWithIndex($node, $value): void
    {
        $this->comparesCount++;

        if ($node === null) {
            return;
        }

        if ($node->key == $value) {
            $this->findDocuments[] = $node->data;
        }

        if ($value < $node->key) {
            $this->searchNodesWithIndex($node->left, $value);
        } else {
            $this->searchNodesWithIndex($node->right, $value);
        }
    }

    private function searchNodesWithoutIndex($node, $value): void
    {
        $this->comparesCount++;

        if ($node === null) {
            return;
        }

        if (in_array($value, $node->data)) {
            $this->findDocuments[] = $node->data;
        }

        $this->searchNodesWithoutIndex($node->left, $value);
        $this->searchNodesWithoutIndex($node->right, $value);
    }
}
