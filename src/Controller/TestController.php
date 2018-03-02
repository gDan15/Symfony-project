<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;


class TestController extends Controller
{
  /**
  * @Route("/note", name="noteTest")
  *
  */
    public function new(Request $request)
    {
        // createFormBuilder is a shortcut to get the "form factory"
        // and then call "createBuilder()" on it

        // $form = $this->createFormBuilder()
        //     ->add('task', TextType::class)
        //     ->add('dueDate', DateType::class)
        //     ->getForm();
        //
        // return $this->render('note/testResponse.html.twig', array(
        //     'form' => $form->createView(),
        // ));
        $formFactory = Forms::createFormFactoryBuilder()
          ->addExtension(new HttpFoundationExtension())
          ->getFormFactory();
        return null;
    }
}
