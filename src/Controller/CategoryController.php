<?php
//TODO : add @param and @return to every function
namespace App\Controller;
use App\Entity\Category;
use App\Form\AddCategory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryController extends Controller
{
  /**
   * @Route("/category", name="category")
   */
  public function index()
  {

  }
  /**
   * @Route("/category/edit/{id}", name="editCategory")
   */
   // TODO : add link for button "home"
  public function editCategory(Category $category, Request $request){
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
    return $this->render('category/addCategory.html.twig', array(
        'form' => $form->createView(),
    ));
  }
  /**
   * @Route("/category/add", name="addCategory")
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
    return $this->render('category/addCategory.html.twig', array(
        'form' => $form->createView(),
    ));
  }
  /**
   * @Route("/category/delete/{id}", name="deleteCategory")
   */
  public function deleteCategory(Category $category){
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($category);
    $entityManager->flush();
    return $this->redirectToRoute("home");
  }
  /**
  * @Route("/category/displayAll", name="displayCategories")
  */
  public function displayAllCategories(){
    $entityManager = $this->getDoctrine()->getRepository(Category::class);
    $categories = $entityManager->findAll();

    return $this->render("category/categories.html.twig", array('categories' => $categories, ));
  }
}
