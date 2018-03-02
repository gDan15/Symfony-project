<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="DateTime")
     */
    private date;



    /**
     * @ORM\Column(type="String")
     */
    private title;



    /**
     * @ORM\Column(type="String")
     */
    private note;


}
