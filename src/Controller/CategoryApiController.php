<?php

namespace App\Controller;
use App\Entity\Category;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryApiController extends Controller
{
    /**
     * @Route("/category/api/get", name="categoryApiGet")
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function index()
    {
      $entityManager = $this->getDoctrine()->getRepository(Category::class);
      $notes = $entityManager->findAll();
      $data = $this->get('jms_serializer')->serialize($notes, 'json');
      $response = new Response($data);
      $response->headers->set('Content-Type', 'application/json');
      $response->headers->set('Access-Control-Allow-Origin', '*');
      return $response;
    }
    /**
     * @Route("/category/api/get/{id}", name="categoryApiGetOne")
     * @Method({"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function getOneCategory($id)
    {
        $entityManager=$this->getDoctrine()->getManager();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $data = $this->get('jms_serializer')->serialize($category, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    /**
      * @Route("/category/api/post", name="categoryApiPost")
      * @Method({"POST"})
      * @param Request $request
      * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
      */
    public function newCategory(Request $request)
    {
       $entityManager = $this->getDoctrine()->getManager();
       $content = $request->getContent();
       if(empty($content))
       {
         return new JsonResponse(array('status'=>'EMPTY','message'=>'The body of this request is empty.'));
       }
       $category = $this->get('jms_serializer')->deserialize($content, Category::class, 'json');
       $entityManager->persist($category);
       $entityManager->flush();

       $response = new Response(new JsonResponse(array('status'=>'ADDED','message'=>'The request has been added.')));
       $response->headers->set('Content-Type', 'application/json');
       $response->headers->set('Access-Control-Allow-Origin', '*');
       return $response;
       // $response = new JsonResponse();
    }
    /**
     * @Route("/category/api/delete/{id}", name="categoryApiDelete")
     * @Method({"DELETE"})
     * @param $id
     */
    public function deleteCategory($id){
      $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
      if(!$category){
        return new JsonResponse(
                  array(
                      'status' => 'UNKNOWN',
                      'message' => "Note doesn't exist"
                  )
              );
      }
      $entityManager=$this->getDoctrine()->getManager();
      $entityManager->remove($category);
      $entityManager->flush();
      return new JsonResponse(
                array(
                    'status' => 'DELETED',
                    'message' => 'This note has been deleted'
                )
            );
    }
    /**
     * @Route("/category/api/put/{id}", name="categoryApiPut")
     * @Method({"PUT", "GET"})
     * @param $id
     */
     // TODO : check category if it doesn't already exit
     public function editCategory($id, Request $request){
      $entityManager=$this->getDoctrine()->getManager();
      $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
      $content = $request->getContent();
      if(empty($content))
      {
        return new JsonResponse(array('status'=>'EMPTY','message'=>'The body of this request is empty.'));
      }
      if (!$category) {
        return new JsonResponse(array('status'=>'UNKNOWN', 'message'=>"Category doesn't exist"));
      }
      $contentRequest = $this->get('jms_serializer')->deserialize($content, Category::class, 'json');
      $category->setWording($contentRequest->getWording());
      $entityManager->flush();

      $response = new JsonResponse(
                array('status' => 'Category Updated',
                    'data' => 'Category has been updated'));

      $response->headers->set('Content-Type','application/json');
      $response->headers->set('Access-Control-Allow-Origin', '*');
      $response->setStatusCode(200);
      return $response;
    }
}
