<?php

namespace instantjay\emailphp;

use Respect\Validation\Validator;

class Recipient {
    private $emailAddress;
    private $name;

    public function __construct($emailAddress, $name = null) {
        if(!Validator::email()->validate($emailAddress))
            throw new \Exception('Invalid e-mail address');

        $this->emailAddress = $emailAddress;
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmailAddress() {
        return $this->emailAddress;
    }
}