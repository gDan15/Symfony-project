<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    public function test(Request $request){
    //   $test = $request->query->get('page');
    //   return $this->render('note/testResponse.html.twig', [
    //       'testString' => $test,
    //   ]);
    // }
    if ($form->get('submit')->isClicked()) {
      echo "test";
      return $this->render('note/testResponse.html.twig', [
          'testString' => $test,
      ]);
    }
  }
}
