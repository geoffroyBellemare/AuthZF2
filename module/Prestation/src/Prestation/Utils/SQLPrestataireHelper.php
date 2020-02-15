<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 04/06/2019
 * Time: 11:16
 */

namespace Prestation\Utils;


class SQLPrestataireHelper
{
    /**
     * @param \Zend\Db\Sql\Sql $sql
     * @return \Zend\Db\Sql\Expression
     */
    static public function getHostProviderQuantitySql ($sql) {
        $selectQuantity = $sql->select();
        $selectQuantity
            ->from(array('p' => 'prestation'))
            ->columns(array('p_quantity'))
            ->where('lr.p_id_prestation = p.p_id');

/*        $selectAgeCategory   = $sql->select();
        $selectAgeCategory
            ->from(array('cal' => 'period_age_linker'))
            ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(cal.c_a_id,':',?)", array($selectAgeCategoryName))))
            ->where('cal.pd_id = pd.pd_id');*/

        return new \Zend\Db\Sql\Expression( '?', array( $selectQuantity ));
    }
    /**
     * @param \Zend\Db\Sql\Sql $sql
     * @return \Zend\Db\Sql\Expression
     */
    static public function getRemainingQuantitySql ($sql) {
        //new \Zend\Db\Sql\Expression('SUM(pd_quantity)')
        $selectQuantity = $sql->select();
        $selectQuantity
            ->from(array('pd' => 'period'))
            ->columns(array(
                'ramaining' => new \Zend\Db\Sql\Expression('SUM(pd_quantity)')
            ))
            ->where('lr.p_id = pd.p_id');

        /*        $selectAgeCategory   = $sql->select();
                $selectAgeCategory
                    ->from(array('cal' => 'period_age_linker'))
                    ->columns(array(new \Zend\Db\Sql\Expression("GROUP_CONCAT(cal.c_a_id,':',?)", array($selectAgeCategoryName))))
                    ->where('cal.pd_id = pd.pd_id');*/

        return new \Zend\Db\Sql\Expression( '?', array( $selectQuantity ));
    }

}