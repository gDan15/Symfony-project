<?php
// /src/Controller/MainController.php
//TODO : add @param and @return to every function
namespace App\Controller;
use App\Entity\Note;
use App\Entity\Category;
use App\Form\AddNote;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;
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
    //TODO : change main to addNote, add tag in database
    public function main(Request $request)
    {
        $defaults = array(
            'dueDate' => new \DateTime('tomorrow'),
        );
        // NOTE : necessary ?
        $category = new Category();
        $note = new Note();
        $form = $this->createForm(AddNote::class, $note);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && 'save' === $form->getClickedButton()->getName()) {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $repositoryCategory = $doctrine->getRepository(Category::class);
            // The name of the category inserted by the user.
            $categoryNameForm = $form->get('category')->getData()->getWording();
            // Search "Category" in the table to see if the name already exists.
            $category = $repositoryCategory->findOneBy(array('wording' => $form->get('category')->getData()->getWording()));
            // If the category doesn't exist in the table insert it in the last.
            if(is_null($category)){
              $category = new Category();
              $category->setWording($form->get('category')->getData()->getWording());
              $entityManager->persist($category);
            }
            // Take the informations entered in the form by the user.
            $note->setTitle($form->get('title')->getData());
            $note->setContent($form->get('content')->getData());
            $note->setDate($form->get('date')->getData());
            $note->setCategory($category);

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
    */
    public function home(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Note::class);
        $notes = $repository->findAll();
        // retrieve POST value from the texttype input in html.twig
        $tag = $request->get('tagSearch');
        if($tag != null){
          $arrayTagNotes=$this->searchTag($tag, $notes);
          $notes=$arrayTagNotes;
        }
        return $this->render('note/homePage.html.twig', array(
            'notes' => $notes,
        ));
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
    public function searchTag(string $tag, $notes){
      $arrayNotes=array();
      foreach ($notes as $note){
        // $entityManager=$this->getDoctrine()->getManager();
        // $content=$entityManager->getContent;
        $content=$note->getContent();
        // $crawler = new Crawler('<root><node /></root>');
        $crawler = new Crawler();
        $crawler->addContent($content);
        $crawler = $crawler->filterXPath('//tag')->extract('_text');
        //TODO : si plusieurs tag dans même TextArea alors cela ne fonctionne pas.
        if(!empty($crawler) && $crawler[0] === $tag){
          array_push($arrayNotes, $note);
        }
      }
      return $arrayNotes;
    }
}
?>
