<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 28/05/2019
 * Time: 15:21
 */

namespace Prestation\Utils;


class SQLHelper
{
    /**
     * @param \Zend\Db\Sql\Sql $sql
     * @return \Zend\Db\Sql\Expression
     */
    static public function getSubtypesSql($sql) {

        $selectSubType = $sql->select();
        $selectSubType
            ->from(array('st' => 'sub_type'))
            ->columns(array(
                'st_name'
            ))
            ->where('st.st_id = stl.st_id');

        $selectSubTypeLinker = $sql->select();
        $selectSubTypeLinker
            ->from(array('stl' => 'period_sub_type_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(stl.st_id,':',?)", array($selectSubType))))
            ->where('stl.pd_id = pd.pd_id');

        return new \Zend\Db\Sql\Expression( '?', array( $selectSubTypeLinker ));

    }
    /**
     * @param \Zend\Db\Sql\Sql $sql
     * @return \Zend\Db\Sql\Expression
     */
    static public function getAgeCategoriesSql ($sql) {

        $selectAgeCategoryName = $sql->select();
        $selectAgeCategoryName
            ->from(array('ca' => 'category_age'))
            ->columns(array('c_a_name'))
            ->where('ca.c_a_id = cal.c_a_id');

        $selectAgeCategory   = $sql->select();
        $selectAgeCategory
            ->from(array('cal' => 'period_age_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(cal.c_a_id,':',?)", array($selectAgeCategoryName))))
            ->where('cal.pd_id = pd.pd_id');

        return new \Zend\Db\Sql\Expression( '?', array( $selectAgeCategory ));
    }
    /**
     * @param \Zend\Db\Sql\Sql $sql
     * @return \Zend\Db\Sql\Expression
     */
    static public function getLevelCategoriesSql ($sql) {

        $selectLevelCategoryName = $sql->select();
        $selectLevelCategoryName
            ->from(array('cl' => 'category_level'))
            ->columns(array('c_l_name'))
            ->where('cl.c_l_id = cll.c_l_id');

        $selectLevelCategory   = $sql->select();
        $selectLevelCategory
            ->from(array('cll' => 'period_level_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(cll.c_l_id,':',?)", array($selectLevelCategoryName))))
            ->where('cll.pd_id = pd.pd_id');

        return new \Zend\Db\Sql\Expression( '?', array( $selectLevelCategory ));

    }

    /**
     * @return \Zend\Db\Sql\Predicate\Predicate
     */
    static public function getPredicateSetPeriodExistingSql ($data) {
        $having = new \Zend\Db\Sql\Having();
        $predicateSet = $having->nest();
        $predicateSet->addPredicate(new \Zend\Db\Sql\Predicate\Operator('pd_start',\Zend\Db\Sql\Predicate\Operator::OPERATOR_EQUAL_TO, $data['start']));
        $predicateSet->andPredicate(new \Zend\Db\Sql\Predicate\Operator('pd_end',\Zend\Db\Sql\Predicate\Operator::OPERATOR_EQUAL_TO, $data['end']));
        foreach ($data['subTypes'] as $id) {
            $predicateSet->andPredicate(new \Zend\Db\Sql\Predicate\Expression("pd_subtypes REGEXP '([^0-9]{0,1}" . $id .":)'"));
        }
        foreach ($data['ageCategories'] as $id) {
            $predicateSet->andPredicate(new \Zend\Db\Sql\Predicate\Expression("pd_age_categories REGEXP '([^0-9]{0,1}" . $id .":)'"));
        }
        foreach ($data['levelCategories'] as $id) {
            $predicateSet->andPredicate(new \Zend\Db\Sql\Predicate\Expression("pd_level_categories REGEXP '([^0-9]{0,1}" . $id .":)'"));
        }

        $predicateSet->unnest();
        return $predicateSet;
    }
}