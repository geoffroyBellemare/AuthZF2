<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 18/10/2018
 * Time: 12:53
 */

namespace Prestation\Validator;


use Zend\I18n\Validator\IsFloat;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use Zend\Validator\StringLength;
use Zend\Validator\ValidatorChain;

class MarkerValidator extends AbstractValidator
{
    public $validatorChain;
    public $options;
    public $validatorMarkerLatLng;
    protected $messageTemplates = array(
        'marker' => [
            'lat' => [],
            'lng' => [],
            'locality' => [],
            'country' => [],
            ]

    );
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->validatorMarkerLatLng = new MarkerLatLngNoRecordExist($options);
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($data)
    {
        $isValid = true;
        $notEmpty = new \Zend\Validator\NotEmpty();
        $stringLength = new StringLength(array('min' => 3));


        if( !$stringLength->isValid($data['country']) ) {
            $isValid = false;
            $this->addMessage('country caraceter not enough', 'country');
        }

        if( !$notEmpty->isValid($data['country']) ) {
            $isValid = false;
            $this->addMessage('pays est est vide', 'country');
        }

        if( !$stringLength->isValid($data['locality']) ) {
            $isValid = false;
            $this->addMessage('locality caraceter not enough', 'locality');
        }
        if( !$notEmpty->isValid($data['locality']) ) {
            $isValid = false;
            $this->addMessage('ville est est vide', 'ville');
        }
        if( !$notEmpty->isValid($data['country']) ) {
            $isValid = false;
            $this->addMessage('pays est est vide', 'country');
        }

        if( !$notEmpty->isValid( $data['lat']) ) {
            $isValid = false;
            $this->addMessage('lat vide', 'lat');
        }

        if( !$notEmpty->isValid($data['lng']) ) {
            $isValid = false;
            $this->addMessage('lng est vide', 'lng');
        }

        if( !$notEmpty->isValid($data['lat']) ) {
            $isValid = false;
            $this->addMessage('le bordel n est est vide', 'lat');
        }
        if( !$notEmpty->isValid($data['lng']) ) {
            $isValid = false;
            $this->addMessage('le bordel n est est vide', 'lng');

        }
        if (!$this->validatorMarkerLatLng->isValid($data)) {
            $isValid = false;
            $this->addMessage('Latlng Already Use', 'lat');
            $this->addMessage('Latlng Already Use', 'lng');
        }
        $this->error('marker');
        //$this->error('lng');

        return $isValid;

        //if(!$isValid)
/*        if ($this->validatorChain->isValid($data)) {
            return true;
        } else {
            return false;
        }*/
    }

/*    public function getMessages()
    {
        return $this->validatorChain->getMessages();
    }*/
    private function addMessage($message, $key) {
        $this->abstractOptions['messageTemplates']['marker'][$key][] = $message ;
    }
}