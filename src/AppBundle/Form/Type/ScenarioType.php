<?php
/**
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class ScenarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('timeframe', ChoiceType::class, array(
                'choices' => array(
                    '10 minutes'    => 10,
                    '20 minutes'    => 20,
                    '60 minutes'    => 60,
                ),
                'choices_as_values' => true,
            ))
            ->add('routes', CollectionType::class, array(
                'entry_type' => RouteType::class
        ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Scenario',
        ));
    }
}

