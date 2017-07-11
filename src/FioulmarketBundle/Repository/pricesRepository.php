<?php

namespace FioulmarketBundle\Repository;

/**
 * pricesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class pricesRepository extends \Doctrine\ORM\EntityRepository {

    /**
     * 
     * @param type $code_postal_id
     * @param type $date_min
     * @param type $date_max
     */
    public function findPrices($code_postal_id, $date_min, $date_max) {
        $query = $this->_em->createQuery('SELECT p.amount from FioulmarketBundle:Prices p '
                . 'where p.postalCodeId = :postal_code_id and p.date between :date_min and :date_max');

        $query->setParameter("postal_code_id", $code_postal_id)
                ->setParameter("date_min", $date_min)
                ->setParameter("date_max", $date_max);
        
        return $query->getResult();
    }

}
