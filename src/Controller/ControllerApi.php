<?php
//TODO : add @param and @return to every function
namespace App\Controller;

use App\Entity\Notes;
use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ControllerApi extends Controller
{
    /**
     * @Route("/note/api/get", name="noteApiGet")
     * @Method({"GET"})
     */
    public function index()
    {
        $entityManager = $this->getDoctrine(Note::class)->getRepository();
        $notes = $entityManager->findAll();
        $data = $this->get('jms_serializer')->serialize($notes, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
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
       $noteManager->persist($note);
       $noteManager->flush();
       $response = new JsonResponse();
    }
}
