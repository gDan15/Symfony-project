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
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getRepository(Note::class);
        $notes = $entityManager->findAll();
        $data = $this->get('jms_serializer')->serialize($notes, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**TODO : cette fonction ne marche pas.
      * @Route("/note/api/post", name="noteApiPost")
      * @Method({"POST"})
      * @param Request $request
      * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
      */
    public function newNote(Request $request)
    {
       $entityManager = $this->getDoctrine()->getManager();
       $content = $request->getContent();
       if(empty($content))
       {
         return new JsonResponse(array('status'=>'EMPTY','message'=>'The body of this request is empty.'));
       }
       $note = $this->get('jms_serializer')->deserialize($content, Note::class, 'json');
       $entityManager->persist($note);
       $entityManager->flush();

       $response = new Response(new JsonResponse(array('status'=>'ADDED','message'=>'The request has been added.')));
       $response->headers->set('Content-Type', 'application/json');
       return $response;
       // $response = new JsonResponse();
    }

    /**
     * @Route("/note/api/delete/{id}", name="noteApiDelete")
     * @Method({"DELETE", "GET"})
     * @param $id
     */
    public function deleteNote($id){
      $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
      $entityManager=$this->getDoctrine()->getManager();
      $entityManager->remove($note);
      $entityManager->flush();
      return new JsonResponse(
                array(
                    'status' => 'DELETED',
                    'message' => 'This note has been deleted'
                )
            );;
    }
}
