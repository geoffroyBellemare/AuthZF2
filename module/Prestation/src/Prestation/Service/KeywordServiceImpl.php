<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 16:08
 */

namespace Prestation\Service;


use Cocur\Slugify\Slugify;
use Prestation\Entity\Aliases;
use Prestation\Entity\Keyword;
use Prestation\Entity\Locality;

class KeywordServiceImpl implements KeywordService
{
    /**
     * @var \Prestation\Repository\KeywordRepository
     */
    public $keywordRepository;
    /**
     * @var \Prestation\Repository\AliasesRepository
     */
    public $aliasesRepository;

    /**
     * KeywordServiceImpl constructor.
     * @param \Prestation\Repository\KeywordRepository $keywordRepository
     * @param \Prestation\Repository\AliasesRepository $aliasesRepository
     */
    public function __construct(\Prestation\Repository\KeywordRepository $keywordRepository, \Prestation\Repository\AliasesRepository $aliasesRepository)
    {
        $this->keywordRepository = $keywordRepository;
        $this->aliasesRepository = $aliasesRepository;
    }

    /**
     * @param $e_id
     * @param $keyword
     * @param [] $aliasesList
     * @return \Prestation\Entity\Keyword |null
     */
    public function save($e_id, $keywordStr, $synonymes = [])
    {

        $slugify = new Slugify();
        $aliasesList = [];
        $synonymes[] = $slugify->slugify($keywordStr, " ");
        $keyword = $this->keywordRepository->findByName($slugify->slugify($keywordStr, " "));
        if( !$keyword ) {
            $keyword = new Keyword();
            $keyword->setName( $slugify->slugify($keywordStr, " ") );
            $keyword->setId( $this->keywordRepository->create($keyword) );
        }
/*        $keyword = new Keyword();
        $keyword->setName( $slugify->slugify($keywordStr, " ") );
        $keyword->setId( $this->keywordRepository->create($keyword) );

        if( !$keyword->getId() ) {
            $keyword = $this->keywordRepository->findByName($keyword->getName());
        }*/

        if( !$keyword ) return null;

        foreach ( $synonymes as $alias ) {
            $aliases = $this->aliasesRepository->findByName($alias);
            if ( !$aliases ) {
                $aliases = new Aliases();
                $aliases->setName($alias);
                $aliases->setId($this->aliasesRepository->create($aliases));
            }

/*            $aliases = new Aliases();
            $aliases->setName($alias);
            $aliases->setId($this->aliasesRepository->create($aliases));

            if ( !$aliases->getId() ) {
                $aliases = $this->aliasesRepository->findByName($alias);
            }*/
            if( $aliases ) {
                $aliasesList[] = $aliases;
                $this->keywordRepository->createRelation(
                    $aliases->getId(),
                    $e_id,
                    $keyword->getId()
                );
            }
        }
        return $keyword;
/*

        foreach ($keywords as $name ) {
            $keyword = new Keyword();
            $keyword->setName( $slugify->slugify($name, " ") );
            $keyword->setId($this->keywordRepository->create($keyword));



            if( !$keyword->getId() ) {
                $keyword = $this->keywordRepository->findByName($keyword->getName());
            }

          $this->keywordRepository->createRelation(
                $object->getId(),
                $e_id,
                $keyword->getId()
            );

        }

        return $keyword;*/
    }
}