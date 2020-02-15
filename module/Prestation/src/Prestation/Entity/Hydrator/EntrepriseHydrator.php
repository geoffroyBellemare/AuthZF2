<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/07/2019
 * Time: 23:14
 */

namespace Prestation\Entity\Hydrator;


use Prestation\Entity\Entreprise;
use Zend\Stdlib\Hydrator\HydratorInterface;

class EntrepriseHydrator implements HydratorInterface
{

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if (!$object instanceof Entreprise) {
            return [];
        }
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {

        if ($object instanceof Entreprise) {
            $object->setUserId(isset($data['user_id'])? $data['user_id']: null);
            $object->setName(isset($data['name'])? $data['name']: null);
            $object->setSiret(isset($data['siret'])? $data['siret']: null);
            $object->setEmail(isset($data['email'])? $data['email']: null);
            $object->setRib(isset($data['rib'])? $data['rib']: null);
            $object->setUserName(isset($data['user_name'])? $data['user_name']: null);
        }

        return $object;
    }
}