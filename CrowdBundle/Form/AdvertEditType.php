<?php


namespace WEB\CrowdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdvertEditType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->remove('date');
    $builder->remove('diff');
  }

  public function getName()
  {
    return 'web_crowdbundle_advert_edit';
  }

  public function getParent()
  {
    return new AdvertType();
  }
}
