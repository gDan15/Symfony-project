<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    /**
     * @Route("/note/test", name="noteTest")
     */
    public function index()
    {
        return $this->render('note/addNote.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
}
