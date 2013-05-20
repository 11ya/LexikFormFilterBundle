<?php

namespace Lexik\Bundle\FormFilterBundle\Tests\Filter\Doctrine;

/**
 * Filter query builder tests.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class DBALQueryBuilderUpdaterTest extends DoctrineQueryBuilderUpdater
{
    public function testBuildQuery()
    {
        parent::createBuildQueryTest('getSQL', array(
            'SELECT i FROM item i',
            'SELECT i FROM item i WHERE i.name LIKE \'blabla\'',
            'SELECT i FROM item i WHERE (i.name LIKE \'blabla\') AND (i.position > 2)',
            'SELECT i FROM item i WHERE (i.name LIKE \'blabla\') AND (i.position > 2) AND (i.enabled = 1)',
            'SELECT i FROM item i WHERE (i.name LIKE \'blabla\') AND (i.position > 2) AND (i.enabled = 1)',
            'SELECT i FROM item i WHERE (i.name LIKE \'%blabla\') AND (i.position <= 2) AND (i.createdAt = \'2013-09-27\')',
            'SELECT i FROM item i WHERE (i.name LIKE \'%blabla\') AND (i.position <= 2) AND (i.createdAt = \'2013-09-27 13:21:00\')',
        ));
    }

    public function testApplyFilterOption()
    {
        parent::createApplyFilterOptionTest('getSQL', array(
            'SELECT i FROM item i WHERE (i.name <> \'blabla\') AND (i.position <> 2)',
        ));
    }

    public function testNumberRange()
    {
        parent::createNumberRangeTest('getSQL', array(
            'SELECT i FROM item i WHERE (i.position > 1) AND (i.position < 3)',
        ));
    }

    public function testNumberRangeDefaultValues()
    {
        parent::createNumberRangeDefaultValuesTest('getSQL', array(
            'SELECT i FROM item i WHERE (i.default_position >= 1) AND (i.default_position <= 3)',
        ));
    }

    public function testDateRange()
    {
        parent::createDateRangeTest('getSQL', array(
            'SELECT i FROM item i WHERE (i.createdAt <= \'2012-05-22\') AND (i.createdAt >= \'2012-05-12\')',
        ));
    }

    public function testDateTimeRange()
    {
        parent::createDateTimeRange('getSQL', array(
            'SELECT i FROM item i WHERE (i.updatedAt <= \'2012-06-10 22:12:00\') AND (i.updatedAt >= \'2012-05-12 14:55:00\')',
        ));
    }

    protected function createDoctrineQueryBuilder()
    {
        return $this->conn
                    ->createQueryBuilder()
                    ->select('i')
                    ->from('item', 'i');
    }
}
