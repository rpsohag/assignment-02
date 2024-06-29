<?php
namespace App\Services;

use App\Model\Entry;

class FileManagementService
{
    public $incomeFile;
    public $expenseFile;
    public $categoryFile;

    public function __construct($incomeFile,$expenseFile,$categoryFile)
    {
        $this->incomeFile = $incomeFile;
        $this->expenseFile = $expenseFile;
        $this->categoryFile = $categoryFile;
    }

    private function readFile($filePath)
    {
        // check if this file does not exists
        if(!file_exists($filePath)){
            return [];
        }

        // read entire file 
        $content=file_get_contents($filePath);

        if($content==false){
            return [];
        }

        // return decoded json string
        return json_decode($content,true);  
    }

    /**
     * takes a file path and data as a parameter
     * put this data as a json encoded value inside this file
     */
    private function writeFile($filePath,$data)
    {
        file_put_contents($filePath, json_encode($data,JSON_PRETTY_PRINT));
    }



    public function addIncome(Entry $entry)
    {
        $incomes=$this->readFile($this->incomeFile);
        $incomes[]=$entry->toArray();
        $this->writeFile($this->incomeFile, $incomes);
    }

    public function addExpense(Entry $entry)
    {
        $expenses=$this->readFile($this->expenseFile);
        $expenses[]=$entry->toArray();
        $this->writeFile($this->expenseFile, $expenses);
    }

    public function getIncomes():array
    {
        $data=$this->readFile($this->incomeFile);
        return array_map([Entry::class,"fromArray"], $data);
    }

    public function getExpenses():array
    {
        $data=$this->readFile($this->expenseFile);
        return array_map([Entry::class,"fromArray"],$data);
    }

    public function getCategories():array
    {
        return $this->readFile($this->categoryFile);
    }

    public function addCategory(string $category):void
    {
        $categories=$this->readFile($this->categoryFile);
        if(!in_array($category, $categories)){
            $categories[]=$category;
            $this->writeFile($this->categoryFile,$categories);
        }
    }
}