<?php
/**
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form Type for adding new Routes
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class RouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uriPattern')
//            ->add('patternType', ChoiceType::class, array(
//                'choices'  => array(
//                    'Begins With' => Route::ROUTE_TYPE_BEGINS_WITH,
//                    'Equals' => Route::ROUTE_TYPE_EQUALS,
//                    'Regex' => Route::ROUTE_TYPE_REGEX,
//                ),
//                'choices_as_values' => true,
//            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Route',
        ));
    }
}

