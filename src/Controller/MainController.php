<?php
// /src/Controller/MainController.php
namespace App\Controller;
use App\Entity\Note;
use App\Form\AddNote;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class MainController extends Controller
{
    /**
    * @Route("/note/main", name="noteMain")
    *
    */
    public function main(Request $request)
    {
        // createFormBuilder is a shortcut to get the "form factory"
        // and then call "createBuilder()" on it
        $defaults = array(
            'dueDate' => new \DateTime('tomorrow'),
        );
        $note = new Note();

        $form = $this->createForm(AddNote::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'save' === $form->getClickedButton()->getName()) {
            // $note = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        elseif ($form->isSubmitted() && 'home' === $form->getClickedButton()->getName()) {
            return $this->redirectToRoute('home');
        }
        return $this->render('note/addNote.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
    * @Route("/note/home", name="home")
    *
    */
    public function home(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Note::class);
        $notes = $repository->findAll();
        // $arrayNotes = array();
        // $informationsNotes = array();
        // foreach($notes as $note){
        //   // array_push($informationsNotes, $note->getId());
        //   array_push($informationsNotes, $note->getCategory());
        //   array_push($informationsNotes, $note->getTitle());
        //   array_push($informationsNotes, $note->getContent());
        //   array_push($arrayNotes, $informationsNotes);
        //   $informationsNotes = array();
        // }
        return $this->render('note/homePage.html.twig', array('notes' => $notes, ));
    }
}
?>
