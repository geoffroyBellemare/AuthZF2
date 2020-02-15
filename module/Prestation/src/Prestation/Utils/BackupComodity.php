<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 02/11/2018
 * Time: 21:10
 */

namespace Admin\Utils;


class BackupComodity {

static public $commodity = [
                        'police' => [
                            'free_spot' => 0,
                            'come_sometimes'=> 1,
                            'skate_only_the_day' => 2,
                            'one_trick_and_go' => 3,
                            'come_after_one_hour' => 4,
                            'skate_only_the_night' => 5,
                            'not-inform' => 6
                        ],
                        'acces' => [
                            'easy' => 0,
                            'not_so_easy' => 1,
                            'hard' => 2,
                            'not-inform' => 3
                        ],
                        'water' => [
                            'water_no' => 0,
                            'water_yes' => 1,
                            'not-inform' => 3
                        ],
                        'toilet' => [
                            'toilet_no' => 0,
                            'toilet_yes' => 1,
                            'not-inform' => 2
                        ],
                        'camping_sauvage' => [
                            'impossible' => 0,
                            '1_day'=> 2,
                            '1_week' => 3,
                            '1_month' => 4,
                            'not-inform' => 5

                        ],
                        'frequentation' => [
                            'nobody' => 0,
                            'not_alone' => 1,
                            'people' => 2,
                            'to_much' => 3,
                            'overdose' => 4,
                            'not-inform' => 5
                        ],
                        'etat_du_spot' => [
                            'new_spot' => 0,
                            'good' => 1,
                            'some_hole'  => 2,
                            'anti_skate'  => 3,
                            'to_remake'  => 4,
                            'pourri'  => 5,
                            'not-inform'  => 6
                        ],
                        'note' => [
                           'note_1' => 1,
                           'note_2' => 2,
                           'note_3' => 3,
                           'note_4' => 4,
                           'note_5' => 5,
                            'not-inform'  => 6
                        ]

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
    static public function getComodity() {
        $keyWords = [];
        $commodities = [];
        $commodityKeys = [
            'police',
            'acces',
            'water',
            'toilet',
            'camping_sauvage',
            'frequentation',
            'etat_du_spot',
            'note'
        ];
        $markers = self::getMarkersFrom();
        foreach ($markers as $marker) {
            foreach($marker as $key => $value ) {
                if( in_array($key, $commodityKeys )) {
                   if( !isset($commodities[$key]) ) {
                       $commodities[$key] = [];
                       $commodities[$key]['count'] = 1;
                       $commodities[$key]['commodity'] = [ $value => 1 ];

                   } else {
                       $commodities[$key]['count']++;
                       $commodities[$key]['commodity'][$value]++;
                   }
                }
            }
/*            $type = $marker['camping_sauvage'];
            if ( !isset($keyWords[$type]) ) {
                $keyWords[$type] = 1;
            } else {
                $keyWords[$type]++;
            }

            $type = $marker['note'];
            if ( !isset($keyWords[$type]) ) {
                $keyWords[$type] = 1;
            } else {
                $keyWords[$type]++;
            }*/

/*            $type = $marker['police'];
            if ( !isset($keyWords[$type]) ) {
                $keyWords[$type] = 1;
            } else {
                $keyWords[$type]++;
            }*/
        }
        //return array_keys($keyWords);
        return $commodities;
    }

    static public function getComoditiesAndNotesForMarker($data = ['police' => 'not-inform', 'acces' => 'not-inform', 'water' => 'not-inform', 'camping_sauvage' => 'impossible']) {
        $commodities =[];

        foreach ($data as $key => $value ) {
            switch ( $key ) {
                case "police" :
                    $commodities[$key] =  self::getComodityNotesByDescription('police', $value);
                    break;
                case "acces" :
                    $commodities[$key] = self::getComodityNotesByDescription($key, $value);
                    break;
                case "water" :
                    $commodities[$key] = self::getComodityNotesByDescription($key, $value);
                    break;
                case "toilet" :
                    $commodities[$key] = self::getComodityNotesByDescription($key, $value);
                    break;
                case "camping_sauvage" :
                    $commodities[$key] = self::getComodityNotesByDescription($key, $value);
                    break;
                case "frequentation" :
                    $commodities[$key] = self::getComodityNotesByDescription($key, $value);
                    break;
                case "etat_du_spot" :
                    $commodities[$key] = self::getComodityNotesByDescription($key, $value);
                    break;
                case "note" :
                    $commodities[$key] = self::getComodityNotesByDescription($key, $value);
                    break;
            }
        }

        return $commodities;
    }

    static public function getComodityNotesByDescription($type, $description) {

        $commodities =[];
        $commoditykeys =  array_keys(self::$commodity[$type]);

        foreach ($commoditykeys as $key) {
            if( $key == $description ) {
                $commodities[$type] = ['description' => $key, 'note' => self::$commodity[$type][$key]];
            }
        }
        return  count($commodities[$type]) > 0 ? $commodities[$type]: [];
    }
}