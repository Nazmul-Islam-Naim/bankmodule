<?php

namespace App\Actions\Locations;

use App\Services\JsonService;
use App\Services\LocationService;
use Illuminate\Support\Facades\Validator;

class bd{

    public $hierarchy = ['division','district','upazila'];
    protected $fillpath ='locations/BD/';

    /**
     * getLocations
     *
     * @param  mixed $data
     * @return void
     */
    public function getLocations($data){
        $key = key(array_slice($data, -1));
        if( $key == 'division'){
            $json = new JsonService('division',storage_path($this->fillpath));
            return $json->all();
        }

        if( $key == 'district'){
            $divisions = new JsonService('division',storage_path($this->fillpath));
            $division = $divisions->where('name',$data['district'])->first();
            if($division){
                $districts = new JsonService('district',storage_path($this->fillpath));
                return $districts->where('division_id',$division['id'])->values();
            }
        }

        if( $key == 'upazila'){
            $districts = new JsonService('district',storage_path($this->fillpath));
            $district = $districts->where('name',$data['upazila'])->first();
            if($district){
                $upazilas = new JsonService('upazila',storage_path($this->fillpath));
                return $upazilas->where('district_id',$district['id'])->values();
            }
        }
    }


    /**
     * requestValidate
     *
     * @param  mixed $address
     * @param  mixed $type
     * @return void
     */
    public function requestValidate($address){
        Validator::make($address['details'], [
           'country'=>  ['required','in:'.implode(',',LocationService::instance()->locations)],
           'division'=>'required',
           'district'=>'required',
           'upazila'=>'required'
        ])->validateWithBag($address['type']);
    }


    /**
     * formater
     *
     * @param  mixed $address
     * @return void
     */
    public function formater($address){
        $details = $address['details'];
        return [
            'country'=>$details['country'],
            'division'=>$details['division'],
            'district'=>$details['district'],
            'upazila'=>$details['upazila'],
            'addressline'=>$address['addressline'],
        ];
    }

}
