<?php
//TODO : add @param and @return to every function
namespace App\Controller;

use App\Entity\Notes;
use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ControllerApi extends Controller
{
    /**
     * @Route("/controller/api", name="controllerApi")
     * 
     */
    public function index()
    {
        $entityManager = $this->getDoctrine(Note::class)->getRepository();
        $notes = $entityManager->findAll();

    }
}
