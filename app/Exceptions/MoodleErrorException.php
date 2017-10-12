<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Exceptions;

use Exception;

/**
 * Description of MoodleErrorException
 *
 * @author filipe_oliveira
 */
class MoodleErrorException extends Exception {

    public $message;

    public function __construct($message) {
        $this->message = $message;
        parent::__construct($message);
    }

}
