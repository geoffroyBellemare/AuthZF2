<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 29/06/2019
 * Time: 14:26
 */

namespace Prestation\Service;


use Prestation\Entity\Caption;

class CaptionServiceImpl implements CaptionService
{
    /**
     * @var \Prestation\Repository\CaptionRepository
     */
    protected $captionRepository;

    /**
     * CaptionServiceImpl constructor.
     * @param \Prestation\Repository\CaptionRepository $captionRepository
     */
    public function __construct(\Prestation\Repository\CaptionRepository $captionRepository)
    {
        $this->captionRepository = $captionRepository;
    }

    /**
     * @param $data
     * @return Caption|null
     */
    public function save($data)
    {
        $caption = $this->captionRepository->findByName($data['caption']);
        if(!$caption) {
            $caption = new Caption();
            $caption->setCaption($data['caption']);
            $caption->setId($this->captionRepository->create($caption));
        }
        return $caption->getId() ? $caption: null;
    }
}