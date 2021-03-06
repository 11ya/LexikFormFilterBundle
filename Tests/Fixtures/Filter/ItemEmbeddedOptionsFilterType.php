<?php

namespace Lexik\Bundle\FormFilterBundle\Tests\Fixtures\Filter;

use Doctrine\MongoDB\Query\Builder;
use Doctrine\MongoDB\Query\Expr as MongoExpr;
use Doctrine\ORM\Query\Expr as ORMExpr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form filter for tests.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class ItemEmbeddedOptionsFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ('mongo' === $options['doctrine_builder']) {
            $addShared = function (FilterBuilderExecuterInterface $qbe) {
                $qbe->addOnce('options', 'options', null);
            };
        } else {
            $addShared = function (FilterBuilderExecuterInterface $qbe) {
                $joinClosure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, ORMExpr $expr) {
                    $filterBuilder->leftJoin($alias . '.options', $joinAlias);
                };
                $qbe->addOnce($qbe->getAlias().'.options', 'opt', $joinClosure);
            };
        }

        $builder->add('name', 'filter_text');
        $builder->add('position', 'filter_number');
        $builder->add('options', 'filter_collection_adapter', array(
            'type'       => new OptionFilterType(),
            'add_shared' => $addShared,
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'doctrine_builder' => null,
        ));
    }

    public function getName()
    {
        return 'item_filter';
    }
}
