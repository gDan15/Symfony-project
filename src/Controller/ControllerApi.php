<?php
//TODO : add @param and @return to every function
namespace App\Controller;

use App\Entity\Note;
use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
class ControllerApi extends Controller
{
    /**
     * @Route("/note/api/get", name="noteApiGet")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getRepository(Note::class);
        $notes = $entityManager->findAll();
        $data = $this->get('jms_serializer')->serialize($notes, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    /**
     * @Route("/note/api/get/{id}", name="noteApiGetOne")
     * @Method({"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function getOneNote($id)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
        $data = $this->get('jms_serializer')->serialize($note, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    /**
      * @Route("/note/api/post", name="noteApiPost")
      * @Method({"POST", "GET"})
      * @param Request $request
      * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
      */
    public function newNote(Request $request)
    {
       // NOTE : necessary ?
       $category = new Category();
       $note = new Note();

       $doctrine = $this->getDoctrine();
       $entityManager = $doctrine->getManager();
       $content = $request->getContent();
       var_dump($content);
       if(empty($content))
       {
         return new JsonResponse(array('status'=>'EMPTY','message'=>'The body of this request is empty.'));
       }
       $repositoryCategory = $doctrine->getRepository(Category::class);
       $contentRequest = $this->get('jms_serializer')->deserialize($content, Note::class, 'json');
       // The name of the category inserted by the user.
       $categoryName = $contentRequest->getCategory()->getWording();
       // Search "Category" in the table to see if the name already exists.
       $category = $repositoryCategory->findOneBy(array('wording' => $categoryName));
       // If the category doesn't exist in the table insert it in the last.
       if(is_null($category)){
         $category = new Category();
         $category->setWording($contentRequest->getCategory()->getWording());
         $entityManager->persist($category);
       }
       $note->setTitle($contentRequest->getTitle());
       $note->setContent($contentRequest->getContent());
       $note->setDate($contentRequest->getDate());
       $note->setCategory($category);

       $entityManager->persist($note);
       $entityManager->flush();

       $response = new Response(new JsonResponse(array('status'=>'ADDED','message'=>'The request has been added.')));
       $response->headers->set('Content-Type', 'application/json');
       $response->headers->set('Access-Control-Allow-Origin', '*');
       return $response;
       // $response = new JsonResponse();
    }

    /**
     * @Route("/note/api/delete/{id}", name="noteApiDelete")
     * @Method({"DELETE"})
     * @param $id
     */
    public function deleteNote($id){
      $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
      if(!$note){
        return new JsonResponse(
                  array(
                      'status' => 'UNKNOWN',
                      'message' => "Note doesn't exist"
                  )
              );
      }
      $entityManager=$this->getDoctrine()->getManager();
      $entityManager->remove($note);
      $entityManager->flush();
      return new JsonResponse(
                array(
                    'status' => 'DELETED',
                    'message' => 'This note has been deleted'
                )
            );
    }
    /**
     * @Route("/note/api/put/{id}", name="noteApiPut")
     * @Method({"PUT", "GET"})
     * @param $id
     */
     public function editNote($id, Request $request){
      $category = new Category();
      $doctrine = $this->getDoctrine();
      $entityManager = $doctrine->getManager();
      $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
      $content = $request->getContent();
      if(empty($content))
      {
        return new JsonResponse(array('status'=>'EMPTY','message'=>'The body of this request is empty.'));
      }
      if (!$note) {
        return new JsonResponse(array('status'=>'UNKNOWN', 'message'=>"Note doesn't exist"));
      }
      $contentRequest = $this->get('jms_serializer')->deserialize($content, Note::class, 'json');
      // The name of the category inserted by the user.
      $categoryName = $contentRequest->getCategory()->getWording();

      $category->setWording($contentRequest->getCategory()->getWording());
      $entityManager->persist($category);

      $note->setTitle($contentRequest->getTitle());
      $note->setContent($contentRequest->getContent());
      $note->setDate($contentRequest->getDate());
      $note->setCategory($category);

      $entityManager->persist($note);
      $entityManager->flush();

      $response = new JsonResponse(
                array('status' => 'Note Updated',
                    'data' => 'Note has been updated'));
      $response->headers->set('Content-Type','application/json');
      $response->headers->set('Access-Control-Allow-Origin', '*');
      $response->setStatusCode(200);
      return $response;
    }
}
