<?php

namespace FioulmarketBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;

/**
 * Description of FioulRest
 *
 * @author user
 */
class FioulRestController extends FOSRestController {

    /**
     * POST Route annotation
     * @Rest\Post("/api/fioul")
     * @Rest\View
     * @return array
     */
    public function fioulAction(Request $request) {
        
        $results = array();
        try {

            $parameters = $request->request->all();
            
            if (array_key_exists("code_postal_id", $parameters) && array_key_exists("date_min", $parameters) && array_key_exists("date_max", $parameters)) {
                
                $prices = $this->getDoctrine()->getManager()
                        ->getRepository("FioulmarketBundle:prices")
                        ->findPrices($parameters['code_postal_id'], $parameters['date_min'], $parameters['date_max']);
                $results['status'] = TRUE;
                $results['results'] = $prices;
            } else {
                $results['status'] = FALSE;
                $results['message'] = "Veuillez renseigner tous les paramètres";
            }
        } catch (Doctrine\ORM\ORMException $ex) {
            $results['status'] = FALSE;
            $results['message'] = "Problème base de données";
        }

        $view = new View($results);
        return $this->handleView($view);
    }

}
