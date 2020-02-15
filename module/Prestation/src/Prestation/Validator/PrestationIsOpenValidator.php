<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/07/2019
 * Time: 21:26
 */

namespace Prestation\Validator;


use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class PrestationIsOpenValidator extends AbstractValidator
{
    /**
     * @var \Prestation\Repository\PrestationRepository
     */
    protected $prestationRepo;
    /**
     * @var \Prestation\Repository\ReservationRepository
     */
    protected $reservationRepo;
    /**
     * @var \Prestation\Repository\PeriodRepository
     */
    protected $periodRepo;
    /**
     * @var \Prestation\Repository\HoraireRepository
     */
    protected $horaireRepo;

    protected $messageTemplates = array(
        'reservations' => [
            'prestation' => [],
            'horaire' => [],
            'periods' => [],
        ]

    );

    /**
     * PrestationIsOpenValidator constructor.
     * @param \Prestation\Repository\PrestationRepository $prestationRepo
     * @param \Prestation\Repository\PeriodRepository $periodReop
     * @param \Prestation\Repository\HoraireRepository $horaireRepo
     */
    public function __construct(\Prestation\Repository\PrestationRepository $prestationRepo, \Prestation\Repository\ReservationRepository $reservationRepo, \Prestation\Repository\PeriodRepository $periodReop, \Prestation\Repository\HoraireRepository $horaireRepo, $options = null)
    {
        parent::__construct($options);
        $this->prestationRepo = $prestationRepo;
        $this->reservationRepo = $reservationRepo;
        $this->periodRepo = $periodReop;
        $this->horaireRepo = $horaireRepo;
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
    public function isValid($value)
    {
        $isValid = true;
        $p_id = $value['p_id'];
        foreach ($value['horaires'] as $key => $horaire) {

            $periods = $this->periodRepo->findByDate($horaire, $p_id);

            if (!$periods) {
                $isValid = false;
                $this->addMessage('Prestation Fermer Pendant cette periode', 'periods');
            } else {
                $horaires = [];
                foreach ($periods as $key2 => $period) {
                    if ( $h = $this->horaireRepo->findByTime($horaire, $period->getPdId())) {
                        $horaires[] = $h;
                    }
                }
                if (count($horaires) == 0) {
                    $isValid = false;
                    $this->addMessage('crenneaux horaire indisponible', 'horaire');
                } else {
                    $reservations = $this->reservationRepo->findByPID($p_id, $horaire);
                    if($reservations) {
                        if (count($reservations) > 3) {
                            $isValid = false;
                            $this->addMessage('crenneaux horaire complet', 'horaire');
                        } else {
                            $this->addMessage(' ', 'horaire');
                        }
                    } else {
                        $this->addMessage(' ', 'horaire');
                    }

                }
            }
        }

/*        if()
        if (!$isValid) {
            $this->addMessage('aucun creneaux pour cette heure', 'horaire');
        }*/

        $this->error('reservations');
        return $isValid;
    }
}