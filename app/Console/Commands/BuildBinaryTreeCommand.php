<?php

namespace App\Console\Commands;

use App\Classes\Tree\BinarySearchTree;
use Illuminate\Console\Command;

class BuildBinaryTreeCommand extends Command
{
    public string $fieldForIndex;
    public mixed $searchValue;

    public function __construct(public BinarySearchTree $bst)
    {
        parent::__construct();
    }

    protected $signature = 'build:binary:tree {fieldForIndex} {searchValue}';

    protected $description = 'Build binary tree';

    public function handle(): void
    {
        $this->bst = new BinarySearchTree();
        $this->fieldForIndex = $this->argument('fieldForIndex');
        $this->searchValue = $this->argument('searchValue');

        $this->buildTree();
        $this->saveIndexKeyInFile();

        $resultWithIndex = $this->findDocumentsWithIndex();
        $resultWithoutIndex = $this->findDocumentsWithoutIndex();

        $this->line('Result with index!\n');
        print_r(json_encode($resultWithIndex) . "\n\n");

        $this->line('Result without index');

        $this->info('Result without index!');
        print_r(json_encode($resultWithoutIndex) . "\n\n");
    }

    private function buildTree(): void
    {
        $data = json_decode(file_get_contents(public_path('documents.txt')), true);

        foreach ($data as $item) {
            if (isset($item[$this->fieldForIndex])) {
                $this->bst->insert($item[$this->fieldForIndex], $item);
            }
        }
    }

    private function saveIndexKeyInFile(): void
    {
        file_put_contents(public_path('binary-index.txt'), json_encode(['indexKey' => $this->fieldForIndex]));
    }

    private function findDocumentsWithIndex(): array
    {
       return $this->bst->search($this->searchValue);
    }

    private function findDocumentsWithoutIndex(): array
    {
        return $this->bst->search($this->searchValue, false);
    }
}
