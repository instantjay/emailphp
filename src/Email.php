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
    private $isHTML;

    /**
     * Email constructor.
     * @param $subject string
     * @param $body string
     * @param null $senderEmailAddress string If sending null will automatically revert to default set when instantiating the Provider object.
     * @param null $senderName string If sending null will automatically revert to default set when instantiating the Provider object.
     * @param null $replyToEmailAddress string
     * @param bool $isHTML bool
     */
    public function __construct($subject, $body, $senderEmailAddress = null, $senderName = null, $replyToEmailAddress = null, $isHTML = true)
    {
        $this->subject = $subject;
        $this->body = $body;

        $this->senderEmailAddress = $senderEmailAddress;
        $this->senderName = $senderName;
        $this->replyToEmailAddress = $replyToEmailAddress;
        $this->isHTML = $isHTML;

        $this->recipients = [];
        $this->ccRecipients = [];
        $this->bccRecipients = [];
    }

    /**
     * @param $recipients Recipient[]
     */
    public function addRecipients($recipients) {
        $this->recipients = array_merge($this->recipients, $recipients);
    }

    /**
     * @param $recipients Recipient[]
     */
    public function addCCRecipients($recipients) {
        $this->ccRecipients = array_merge($this->ccRecipients, $recipients);
    }

    /**
     * @param $recipients Recipient[]
     */
    public function addBCCRecipients($recipients) {
        $this->bccRecipients = array_merge($this->bccRecipients, $recipients);
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getBody() {
        return $this->body;
    }

    /**
     * @return Recipient[]
     */
    public function getRecipients() {
        return $this->recipients;
    }

    /**
     * @return Recipient[]
     */
    public function getCCRecipients() {
        return $this->ccRecipients;
    }

    /**
     * @return Recipient[]
     */
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

    public function isHTML() {
        return $this->isHTML;
    }
}