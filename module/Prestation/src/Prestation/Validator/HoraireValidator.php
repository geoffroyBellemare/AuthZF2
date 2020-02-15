<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/05/2019
 * Time: 17:27
 */

namespace Prestation\Validator;


use Prestation\Service\HoraireService;
use Prestation\Service\PrestataireService;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class HoraireValidator extends AbstractValidator
{
    protected $messageTemplates = array(
        'prestation' => [
            'name' => [],
            'horaire' => [],
            'periods' => [],
        ]

    );
    /**
     * @var \Prestation\Repository\PrestataireRepository
     */
    protected $prestationRepo;
    /**
     * @var \Prestation\Service\PrestataireService
     */
    protected $prestatairesService;

    /**
     * HoraireValidator constructor.
     * @param $horaireService
     */
    public function __construct(\Prestation\Repository\PrestationRepository $prestationRepo, PrestataireService $prestataireService)
    {
        parent::__construct(null);
        $this->prestationRepo = $prestationRepo;
        $this->prestatairesService = $prestataireService;
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
        $periods = $data['periods'];
//si hote pas libre

// prestation contien deja cette periode
        $prestation = $this->prestationRepo->isRecordExist($data);
        if ($prestation) {

            $this->addMessage('Cette prestation exist deja', 'name');
            $isValid = false;
        }


        foreach ($periods as $period) {
            if( !$this->prestatairesService->isHostOpen($period) ) {
                $this->addMessage('la prestation hote n est pas ouvert', 'periods');
                $isValid = false;
            }
            if( !$this->prestatairesService->isHostFree($period)) {
                $this->addMessage('la prestation hote n a pu de place', 'periods');
                $isValid = false;
            }
            //$this->prestatairesService->isFreeHost($period['p_host_id'], ['start' => $period['start'], 'end' => $period['end']]);
            foreach ($period['horaire'] as $key => $horaire) {
                $pvr_id = $horaire['provider'];
                $date = $horaire['start'];


/*               if (!$h) {
                   $this->addMessage('Prestataire deja occuper please change him', $key);
                   $isValid = false;
               }*/
              // $this->prestationRepo->isFree();
               // $h = $this->prestationService->isFree($data);

/*                if (!$h) {
                    $this->addMessage('creneau horaire utiliser', $key);
                    $isValid = false;
                }*/

            }
        }

        $this->error('prestation');
        //$this->error('horaire');
        return $isValid;
    }

    private function addMessage($message, $key) {
        $this->abstractOptions['messageTemplates']['prestation'][$key][] = $message ;
    }


}