<?php

namespace instantjay\emailphp;

use Respect\Validation\Validator;

class Recipient {
    private $emailAddress;
    private $name;

    /**
     * Recipient constructor.
     * @param $emailAddress string
     * @param null $name string
     * @throws \Exception
     */
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