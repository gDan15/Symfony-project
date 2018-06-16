<?php
// src/Form/AddCategory.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AddCategory extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('wording', TextType::class, array('label' => 'Nom', 'required' => false))
      ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
      ->add('listCategory', SubmitType::class, array('label' => 'Retour a la liste de catégorie'))
      ->getForm();
  }
}
?>
