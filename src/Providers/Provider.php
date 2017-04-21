<?php

namespace instantjay\emailphp\Providers;

use instantjay\emailphp\Email;

abstract class Provider {
    protected $defaultSenderEmailAddress;
    protected $defaultSenderName;

    public function __construct($defaultSenderEmailAddress, $defaultSenderName) {

    }

    /**
     * @param $email Email
     * @return mixed
     */
    abstract function send($email);
}