<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="category", cascade={"remove"})
     */
    private $notes;
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Veuillez entrer une valeur")
     * @Assert\NotNull(message="Veuillez entrer une valeur")
     */
    private $wording;
    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(){
      return $this->id;
    }

    public function getWording(){
      return $this->wording;
    }

    public function setWording($name){
      $this->wording = $name;
    }
    /**
    * @return Collection|Note[]
    */
    public function getNotes() : ArrayCollection{
      return $this->notes;
    }

    public function addNote(Note $note){
      $this->notes->add($note);
    }
    // public function removeNote(Note $note): self
    // {
    //     if ($this->notes->contains($note)) {
    //         $this->notes->removeElement($note);
    //         // set the owning side to null (unless already changed)
    //         if ($note->getCategory() === $this) {
    //             $note->setCategory(null);
    //         }
    //     }
    //
    //     return $this;
    // }
}
