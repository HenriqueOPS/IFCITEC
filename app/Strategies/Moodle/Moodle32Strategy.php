<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Strategies\Moodle;

/**
 * Description of Moodle32Strategy
 *
 * @author filipe_oliveira
 */
class Moodle32Strategy {
    const SITE_INFO = "core_webservice_get_site_info";
    const USER_FUNCTION = "core_user_get_users_by_field";

    public function getParams(array $data) {
        return [
            'field' => 'id',
            'values[0]' => $data['userid'],
            ];
    }

    public function siteInfoFunctionName() {
        return self::SITE_INFO;
    }

    public function userFunctionName() {
        return self::USER_FUNCTION;
    }
    
}
