<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 27/07/2019
 * Time: 14:16
 */

namespace Prestation\Validator;


use Prestation\Repository\PrestationRepository;
use Prestation\Service\ReservationService;
use Prestation\Utils\DateManipulation;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class ReservationValidator extends AbstractValidator
{
    /**
     * @var \Prestation\Service\ReservationService
     */
    protected $reservationService;

    protected $messageTemplates = array(
        'reservations' => [
            'prestation' => [],
            'horaire' => [],
            'periods' => [],
        ]

    );
    public function __construct(ReservationService $reservationService, $options = null)
    {
        parent::__construct($options);
        $this->reservationService = $reservationService;
    }
    private function addMessage($message, $key) {
        $this->abstractOptions['messageTemplates']['reservations'][$key][] = $message ;
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
        // TODO: Implement isValid() method.
        $isValid = false;
        foreach ($data['periods'] as $key => $period) {
            foreach ($period['horaire'] as $p_key => $time) {
                $horaire =[
                    'start' => DateManipulation::convertDateStringToTimeStamp($time['start']),
                    'end' => DateManipulation::convertDateStringToTimeStamp($time['end'])
                    ];
               if( $this->reservationService->isPrestationFReeSpace($period['p_id_prestation'], $horaire) ){
                   $isValid = false;
                   $this->addMessage('Plus de place pour cette horaires', 'prestation');
               }
            }
        }
        $this->error('reservations');
/*        $notEmptyValidator = new \Zend\Validator\NotEmpty();
        if( !$notEmptyValidator->isValid($value['p_id']) ) {
            $isValid = false;
            $this->addMessage('pas de prestation enregistrer pour cette id', 'prestation');
        }*/

        return $isValid;
    }
}