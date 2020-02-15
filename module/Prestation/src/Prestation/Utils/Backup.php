<?php
/**
 * Created by PhpStorm.
 * User: geoffroy
 * Date: 30/08/2018
 * Time: 17:44
 */

namespace Prestation\Utils;


class Backup
{
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

    static public function updateRegion( $data )
    {
        $markers = self::getMarkersFrom();
        $file = $_SERVER['DOCUMENT_ROOT'] . '/resources/geoloc.json';
        $jsondata = file_get_contents($file);
        $spots = json_decode($jsondata, true);

        foreach ( $data as $item ) {
           $id = $item['id'];

           if ( isset( $item['administrative_area_level_1'] ) && isset( $item['administrative_area_level_2'] ) ) {
               $region = $item['administrative_area_level_1'];
               $department = $item['administrative_area_level_2'];
               $spots['address'][$id]['address_components'][] = [
                   'long_name' => $region,
                   'types' => [
                       'administrative_area_level_1'
                   ]
               ];
               $spots['address'][$id]['address_components'][] = [
                   'long_name' => $department,
                   'types' => [
                       'administrative_area_level_2'
                   ]
               ];
           }


        }
        self::setGeolocBackup($spots);
        //return $data['address'][0]['address_components'];
        return $spots;
    }
    static public function getEmptyWith($field) {
        $markers = self::getMarkersFrom();
        $file = $_SERVER['DOCUMENT_ROOT'].'/resources/geoloc.json';
        $jsondata = file_get_contents($file);
        $data  = json_decode($jsondata, true);
        $emptyRegion = [];
        //var_dump($data['address'][0]['address_components']);
        foreach ($data['address'] as $key => $value) {
            $test = array_filter($value['address_components'], function($address) use ($field) {
                //var_dump($address);
                return $address['types'][0] == $field;
            });

            if (count($test) == 0 ){

                $empty = array_filter($value['address_components'], function($component) {
                    return $component['types'][0] == 'locality' ||
                            $component['types'][0] == 'postal_code' ||
                            $component['types'][0] == 'country';
                });
                $locality = array_reduce($empty, function($carry, $item) {
                    switch($item['types'][0]) {
                        case 'locality':
                            $carry['locality'] = $item['long_name'];
                            break;
                        case 'postal_code':
                            $carry['postal_code'] = $item['long_name'];
                            break;
                        case 'country':
                            $carry['country'] = $item['long_name'];
                            break;
                    }
                    return $carry;
                }, []);
                $locality['id'] = $key;

                $emptyRegion[] = $locality;
            }
        }
        return $emptyRegion;
    }
    static public function getGeolocBackupById($id) {
        $file = $_SERVER['DOCUMENT_ROOT'].'/resources/geoloc.json';
        $jsondata = file_get_contents($file);
        $data  = json_decode($jsondata, true);
        foreach ($data['address'] as $key => $value ) {
            // converts json data into array
            if ($key == $id ) {
                return $value;
            }
        }
        return null;
    }
    static public function getGeolocBackup() {
        $file = $_SERVER['DOCUMENT_ROOT'].'/resources/geoloc.json';
        $jsondata = file_get_contents($file);
        $data  = json_decode($jsondata, true);
        // converts json data into array
        //return $data;
        return self::geolocHelper($data);
    }
    static public function getBackupMarkers() {
        $file = $_SERVER['DOCUMENT_ROOT'].'/resources/geoloc.json';
        $jsondata = file_get_contents($file);
        $data  = self::geolocHelper(json_decode($jsondata, true));
        $spots = [];
        // converts json data into array
        //return $data;
        $countries = [];
/*        $test = array_filter($data, function($address) {
            return $address['administrative_area_level_1'] == '';
        });
        return $test;*/
/*        $countryArray = array_map(function( $address ) {
            return $address['country'];
        }, $data);

        foreach( $countryArray as $country){
            if(!isset( $countries[$country]) ){
                $countries[$country] = 1;
            } else {
                $countries[$country] +=1;
            }backupGeolocCountry
        }*/
/*        foreach($data as $value){
            $country = $value['country'];
            $region = $value['administrative_area_level_1'];
            $marker = $value['marker'];
            if(!isset( $spots[$country]) ){
                $spots[$country] = [ ];
                $spots[$country][$region] =[$marker];
            } else if( !isset( $spots[$country][$region] ) ) {
                $spots[$country][$region] =[$marker];
            } else {
                $spots[$country][$region][] = $marker;
            }

        }*/

        foreach($data as $value){

            $country = $value['country'];
            $region = $value['administrative_area_level_1'];
            $marker = $value['marker'];
            if(!isset( $spots[$country]) ){
                $spots[$country] = [ ];
                $spots[$country][$region] =[$value];
            } else if( !isset( $spots[$country][$region] ) ) {
                $spots[$country][$region] = [$value];
            } else {
                $spots[$country][$region][]= $value;
            }

        }

        return $spots;
        //return $data;

    }
    static public function setGeolocBackup($data) {
         $file = self::getGeolocBackup();

        $file = $_SERVER['DOCUMENT_ROOT'].'/resources/geoloc.json';
        $jsondata = json_encode($data, JSON_PRETTY_PRINT);
        $variables['data'] = $_SERVER['DOCUMENT_ROOT'].'/resources/geoloc.json';
        file_put_contents($file, $jsondata);
    }

    static public function geolocHelper($data) {
        $addressComponents = [];
        $markers = self::getMarkersFrom();
        foreach ($data['address'] as $key => $value ) {

            $address = [];
            $markers[$key]['id'] = $key + 1;
            $address['marker'] = $markers[$key];

            foreach ($value['address_components'] as $key2 => $value2 ) {
                switch($value2['types'][0]) {
                    case 'street_number':
                        $address['street_number'] = $value2['long_name'];
                        break;
                    case 'establishment':
                    case 'point_of_interest':
                    case 'park':
                    case 'premise':
                        $address['bis'] = $value2['long_name'];
                    case 'route':
                    case 'bus_station':
                    case 'transit_station':
                        $address['route'] = $value2['long_name'];
                        break;
                    case 'locality':
                    case 'postal_town':
                        $address['locality'] = $value2['long_name'];
                        break;
                    case 'administrative_area_level_2':
                        $address['administrative_area_level_2'] = $value2['long_name'];
                        break;
                    case 'administrative_area_level_1':
                        $address['administrative_area_level_1'] = $value2['long_name'];
                        break;
                    case 'country':
                        $address['country'] = $value2['long_name'];
                        $address['country_code'] = $value2['short_name'];
                        break;
                    case 'postal_code':
                        $address['postal_code'] = $value2['long_name'];
                        break;
                }
            }

            $addressComponents[] = $address;
        }
        return $addressComponents;
    }
}