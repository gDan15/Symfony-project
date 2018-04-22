<?php
// src/Form/TaskType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AddNote extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('title', TextType::class, array('label' => 'Titre'))
      ->add('content', TextType::class, array('label' => 'Contenu'))
      ->add('date', DateType::class, array('label' => 'Date'))
      ->add('category', TextType::class, array('label' => 'Catégorie'))
      ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
      ->add('home', SubmitType::class, array('label' => "Retour à la page d'accueil"))
      ->getForm();
  }
}
?>
