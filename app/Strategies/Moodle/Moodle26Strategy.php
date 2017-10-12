<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Strategies\Moodle;

/**
 * Description of Moodle26Strategy
 *
 * @author filipe_oliveira
 */
class Moodle26Strategy {
    
    const SITE_INFO = "moodle_webservice_get_siteinfo";
    const USER_FUNCTION = "moodle_user_get_users_by_id";

    public function getParams(array $data) {
        return ['userids' => [$data['userid']]];
    }

    public function siteInfoFunctionName() {
        return self::SITE_INFO;
    }

    public function userFunctionName() {
        return self::USER_FUNCTION;
    }

}
