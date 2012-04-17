<?php

namespace Lexik\Bundle\FormFilterBundle\Tests\Fixtures\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Lexik\Bundle\FormFilterBundle\Filter\Extension\Type\TextFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Extension\Type\NumberFilterType;

/**
 * Form filter for tests.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class OtherFilterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('position', 'filter_number_range', array(
                'left_number' => array('condition_operator' => NumberFilterType::OPERATOR_GREATER_THAN),
                'right_number' => array('condition_operator' => NumberFilterType::OPERATOR_LOWER_THAN_)
                ))
                ->add('createdAt', 'filter_date_range', array(
                'left_date' => array('widget' => 'choice'),
                'right_date' => array('widget' => 'choice')
                ));
    }

    public function getName()
    {
        return 'item_filter';
    }
}
