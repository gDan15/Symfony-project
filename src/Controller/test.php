<?php
// /src/Controller/TaskController.php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class test extends Controller
{
  /**
  * @Route("/note/test", name="noteTest")
  *
  */
    public function new(Request $request)
    {
        // createFormBuilder is a shortcut to get the "form factory"
        // and then call "createBuilder()" on it
        $defaults = array(
            'dueDate' => new \DateTime('tomorrow'),
        );
        $form = $this->createFormBuilder()
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->render('lucky/index.html.twig', [
                'controller_name' => 'LuckyController',
            ]);
        }
        return $this->render('note/new.twig.html', array(
            'form' => $form->createView(),
        ));
    }
}
?>
