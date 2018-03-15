<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ControllerApi extends Controller
{
    /**
     * @Route("/controller/api", name="controller_api")
     * @Method{GET}
     */
    public function index()
    {
        $entityManager = $this->getDoctrine(Note::class)->getRepository();
        $notes = $entityManager->findAll();
        
    }
}
