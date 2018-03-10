<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $wording;

    public function getId(){
      return $this->id;
    }

    public function getWording(){
      return $this->wording;
    }

    public function setWording($wording){
      $this->wording = $wording;
    }
}
