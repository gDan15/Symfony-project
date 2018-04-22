<?php
// /src/Controller/MainController.php
//TODO : add @param and @return to every function
namespace App\Controller;
use App\Entity\Note;
use App\Form\AddNote;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
class MainController extends Controller
{
    /**
    * @Route("/note/main", name="noteMain")
    *
    */
    //TODO : change main to addNote
    public function main(Request $request)
    {
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
    * TODO : is the parameter really necessary in this case ?
    */
    public function home(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Note::class);
        $notes = $repository->findAll();

        return $this->render('note/homePage.html.twig', array('notes' => $notes, ));
    }
    /**
    * @Route("/note/edit/{id}", name="editNote")
    * @param Note $note
    *
    */
    public function editNote(Request $request, Note $note){

        //TODO : have to change the names of the buttons in the form
        $form = $this->createForm(AddNote::class, $note);
        $form->handleRequest($request);
        //TODO : have to change the name of the button in the following if
        if ($form->isSubmitted() && $form->isValid() && 'save' === $form->getClickedButton()->getName()) {
            $note = $form->getData();
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
    * @Route("/note/delete/{id}", name="deleteNote")
    * @param Note $note
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function deleteNote(Note $note){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($note);
        $entityManager->flush();
        return $this->redirectToRoute("home");
    }
}
?>
