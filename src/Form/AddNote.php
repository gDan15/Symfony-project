<?php
// src/Form/TaskType.php
namespace App\Form;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AddNote extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('title', TextType::class, array('label' => 'Titre', 'required' => false))
      ->add('content', TextareaType::class, array('label' => 'Contenu', 'required' => false))
      ->add('date', DateType::class, array('label' => 'Date'))
      ->add('category', AddCategoryType::class, array('label' => 'Catégorie', 'required' => false))
      ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
      ->add('home', SubmitType::class, array('label' => "Retour à la page d'accueil"))
      ->getForm();
  }
}
?>
