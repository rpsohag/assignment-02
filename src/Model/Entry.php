<?php
namespace App\Model;

class Entry
{
    public $amount;
    public $category;
    public $date;

    public function __construct($amount,$category,$date)
    {
        $this->amount = $amount;
        $this->category = $category;
        $this->date = $date;
        
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getDate()
    {
        return $this->date;
    }


    public function toArray()
    {
        return [
            "amount"=>$this->amount,
            "category"=>$this->category,
            "date"=>$this->date
        ];
    }

    public static function fromArray($data)
    {
        return new self($data["amount"],$data["category"],$data["date"]);
    }

}