<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\SearchRepository;


class SearchFilters
{
    

    private $categories;

    private $id;

    private $string;

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get the value of string
     */ 
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set the value of string
     *
     * @return  self
     */ 
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }
}
