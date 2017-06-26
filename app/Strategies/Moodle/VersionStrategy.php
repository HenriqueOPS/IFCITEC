<?php

namespace App\Strategies\Moodle;

//
use App\Escola;
use App\Strategies\Moodle\Moodle26Strategy;
use App\Strategies\Moodle\Moodle32Strategy;

class VersionStrategy {

    private $strategy;
    private $token;
    private $format;
    
    public function __construct(Escola $escola, String $token = null, String $format = null) {
        $this->token = $token;
        $this->format = $format;
        
        switch ($escola->moodle_versao) {
            case '2-6':
                $this->strategy = new Moodle26Strategy();
                break;
            case '3-2':
                $this->strategy = new Moodle32Strategy();
                break;
        }
    }

    private function siteInfoFunctionName() {
        return $this->strategy->siteInfoFunctionName();
    }

    private function userFunctionName() {
         return $this->strategy->userFunctionName();
    }

    public function getParamsForUserId() {
        return [
            'wsfunction' => $this->siteInfoFunctionName(),
            'wstoken' => $this->token,
            'moodlewsrestformat' =>  $this->format
        ];
    }

    public function getParams(array $data) {
        $params = [
            'wsfunction' => $this->userFunctionName(),
            'wstoken' =>  $this->token,
            'moodlewsrestformat' =>  $this->format,
        ];

        return array_merge($params, $this->strategy->getParams($data));
    }

}
