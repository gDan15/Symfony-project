<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Validator as AcmeAssert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
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
    private $title;
    /**
     * @ORM\Column(type="string", length=100)
     * 
     */
    private $content;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="string", length=100)
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="wording")
     */
    private $category;

    public function setCategory($category){
      $this->category = $category;
    }

    public function setTitle($title){
      $this->title = $title;
    }

    public function setDate(\DateTime $date = null){
      $this->date = $date;
    }

    public function setContent($content){
      $this->content = $content;
    }


    public function getId(){
      return $this->id;
    }

    public function getCategory(){
      return $this->category;
    }

    public function getTitle(){
      return $this->title;
    }

    public function getDate(){
      if($this->date != null){
        return $this->date;
      }
    }

    public function getContent(){
      return $this->content;
    }

}
