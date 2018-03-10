<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\AddCategory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
  /**
   * @Route("/category", name="category")
   */
  public function index()
  {

  }
  /**
   * @Route("/note/category/edit/{id}", name="editCategory")
   */
   // TODO : add link for button "home"
  public function editCategory(Category $category, Request $request){
    $form->createForm(AddCategory::class, $category);
    $form->handleRequest($Request);
    if ($form->isSubmitted() && $form->isValid() && 'save' === $form->getClickedButton()->getName())
    {
      $category=$form->getData();
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($category);
      $entityManager->flush();
      return $this->redirectToRoute('home');
    }
    return $this->render('note/addCategory.html.twig', array(
        'form' => $form->createView(),
    ));
  }
  /**
   * @Route("/note/category/add", name="addCategory")
   */
  public function addCategory(Request $request){
    $category= new Category();
    $form = $this->createForm(AddCategory::class, $category);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid() && 'save' === $form->getClickedButton()->getName())
    {
      $category=$form->getData();
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($category);
      $entityManager->flush();
      return $this->redirectToRoute('home');
    }
    return $this->render('note/addCategory.html.twig', array(
        'form' => $form->createView(),
    ));
  }
  /**
   * @Route("/note/category/delete/{id}", name="deleteCategory")
   */
  public function deleteCategory(Request $request){
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($category);
    $entityManager->flush();
    return $this->redirectToRoute("home");
  }
}
