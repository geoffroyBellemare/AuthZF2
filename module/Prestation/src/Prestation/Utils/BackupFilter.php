<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 31/10/2018
 * Time: 10:47
 */

namespace Prestation\Utils;


use Cocur\Slugify\Slugify;

class BackupFilter
{
    static public $aliases = [
        ["Street", "Spot Street", "spot street", "spot_street"],
        ["Manual Pad", "manual pad", "manual_pad", "wheeling", "table a wheeling"],
        ["not-inform"],
        ["Skatepark", "skatepark", "skateparc", "skate parc"], ["Ledge", "ledge", "bench", "grind"], ["Plan Incline", "plan_incline"], ["Curb", "curb"], ["Dirt", "Bmx Dirt", "bmx_dirt", "piste_de_bosses", "dirt"], ["Mini Rampe", "Micro Ramp", "mini rampe", "mini", "mini_rampe"], ["Rail Rond", "rail rond", "rail_rond"], ["Marches", "marches", "stairs", "set_marches"], ["Curb Arrondi", "curb arrondi", "curb_arrondi"], ["Courbes", "quarter", "transition", "courbes"], ["Indoor", "couvert", "indoor"], ["Spine", "spine"], ["Flat", "flat"], ["Bowll",  "bowll", "bowl", "pool"], ["Rail Carre", "rail carre", "rail_carre"], ["Curb oblique", "curb_oblique"], ["Wall", "wall"], ["Do It Yourself", "DIY", "do_it_yourself"], ["Ditch", "ditch"], ["Gap", "gap"], ["Mega Rampe", "mega ramp", "mega", "mega_rampe", "Mega"], ["table complex", "table_complex"], ["Flat Barre", "Flat Bare", "flat barre carre", "flat_barre_ronde", "flat_barre_carre"], ["Snake", "snake run", "snake_run"], ["funbox"], ["pyramide"], ["Street Gap", "street_gap"], ["Pole Jam", "poteau_oblique"],
        ["Full Pipe", "full pipe", "full_pipe"], ["Table", "table"], ["bump"], ["cradle"]
    ];
    static public function getMarkersFrom($file_url ='http://zf2.com/markers.xml')
    {
        $xml = simplexml_load_file($file_url);
        $markers = array();
        foreach ( $xml as $key => $data) {
            $marker = array();
            foreach($data->attributes() as $column => $value ){
                $marker[$column] = (string)$value;
            }
            $markers[] = $marker;
        }

        return $markers;
    }

    static public function getTypesAndMain() {
        $keyWords = [];
        $markers = self::getMarkersFrom();
        foreach ($markers as $marker) {
            $type = $marker['type'];

            if($type == 'bowl' || $type == 'Bowl')continue;

            if ( !isset($keyWords[$type]) ) {
                $keyWords[$type] = [];
                $keyWords[$type]['count'] = 1;
                $keyWords[$type]['aliases'] = self::findAliases($type);
            } else {
                $keyWords[$type]['count']++;
            }
            $type = $marker['the_main'];
            if ( !isset($keyWords[$type]) ) {
                $keyWords[$type] = [];
                $keyWords[$type]['count'] = 1;
                $keyWords[$type]['aliases'] = self::findAliases($type);
            } else {
                $keyWords[$type]['count']++;
            }

        }

        return $keyWords;
    }

    static public function findAliases( $keyword ){
        $slugify = new Slugify();
        $aliasesFilter = array_filter( self::$aliases, function($list) use ($keyword) {
            return in_array($keyword , $list);
        });
        $aliases = [];
        foreach ($aliasesFilter as $key => $value) {
            $aliases = array_filter($value, function($alias) use ($slugify, $keyword) {
                return $slugify->slugify($alias, " ") != $slugify->slugify($keyword, " ");
            });
            return array_unique($aliases);
        }



    }
}