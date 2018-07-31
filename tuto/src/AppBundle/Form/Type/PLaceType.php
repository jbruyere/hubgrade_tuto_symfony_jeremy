<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PLaceType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('login');
		$builder->add('address');
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefults([
			'data_class' => 'AppBundle\Entity\Place',
			'csrf_protection' => false
		]);
	}
}
?>