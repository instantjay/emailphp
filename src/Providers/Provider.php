<?php

namespace instantjay\emailphp\Providers;

use instantjay\emailphp\Email;

abstract class Provider {
    /**
     * @param $email Email
     * @return mixed
     */
    abstract function send($email);
}