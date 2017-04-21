<?php

namespace instantjay\emailphp;

use Respect\Validation\Validator;

class Email {
    private $recipients;
    private $ccRecipients;
    private $bccRecipients;
    private $replyToEmailAddress;

    private $subject;
    private $body;
    private $senderEmailAddress;
    private $senderName;
    private $deliveryTime;

    public function __construct($subject, $body, $senderEmailAddress = null, $senderName = null, $replyToEmailAddress = null)
    {
        $this->subject = $subject;
        $this->body = $body;

        $this->senderEmailAddress = $senderEmailAddress;
        $this->senderName = $senderName;
        $this->replyToEmailAddress = $replyToEmailAddress;

        $this->recipients = [];
        $this->ccRecipients = [];
        $this->bccRecipients = [];
    }

    public function addRecipients($recipients) {
        $this->recipients = array_merge($this->recipients, $recipients);
    }

    public function addCCRecipients($recipients) {
        $this->ccRecipients = array_merge($this->ccRecipients, $recipients);
    }

    public function addBCCRecipients($recipients) {
        $this->bccRecipients = array_merge($this->bccRecipients, $recipients);
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getBody() {
        return $this->body;
    }

    public function getRecipients() {
        return $this->recipients;
    }

    public function getCCRecipients() {
        return $this->ccRecipients;
    }

    public function getBCCRecipients() {
        return $this->bccRecipients;
    }

    public function getSenderName() {
        return $this->senderName;
    }

    public function getSenderEmailAddress() {
        return $this->senderEmailAddress;
    }

    public function getReplyToEmailAddress() {
        return $this->replyToEmailAddress;
    }

    public function setDeliveryTime($deliveryTime) {
        if(!Validator::date('D, d M Y H:i:s O')->validate($deliveryTime))
            throw new \Exception('Time is not valid RFC 2822 format.');

        if(strtotime($deliveryTime) < time())
            throw new \Exception('Delivery time may not be in the past.');

        $this->deliveryTime = $deliveryTime;
    }

    public function getDeliveryTime() {
        return $this->deliveryTime;
    }
}