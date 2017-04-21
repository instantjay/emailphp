<?php

namespace instantjay\emailphp\Providers;

use instantjay\emailphp\Recipient;

class Mailgun extends Provider {
    private $apiKey;
    private $domain;

    private $defaultSenderEmailAddress;
    private $defaultSenderName;

    public function __construct($apikey, $domain, $defaultSenderEmailAddress, $defaultSenderName)
    {
        parent::__construct($defaultSenderEmailAddress, $defaultSenderName);

        $this->apiKey = $apikey;
        $this->domain = $domain;
    }

    public function send($email) {
        $mailgun = \Mailgun\Mailgun::create($this->apiKey);

        $s = [
            'from' => "$this->defaultSenderName <$this->defaultSenderEmailAddress>",
            'subject' => $email->getSubject(),
            'to' => $this->buildRecipientList($email->getRecipients()),
            'cc' => $this->buildRecipientList($email->getCCRecipients()),
            'bcc' => $this->buildRecipientList($email->getBCCRecipients())
        ];

        if($email->getReplyToEmailAddress()) {
            $s['h:Reply-To'] = $email->getReplyToEmailAddress();
        }

        if($email->isHTML()) {
            $s['text'] = 'Your e-mail client does not support HTML.';
            $s['html'] = $email->getBody();
        }
        else {
            $s['text'] = $email->getBody();
        }

        if($email->getDeliveryTime()) {
            $s['o:deliverytime'] = $email->getDeliveryTime();
        }

        $mailgun->messages()->send($this->domain, $s);
    }

    /**
     * @param $recipients Recipient[]
     * @returns string
     */
    private function buildRecipientList($recipients) {
        $result = null;

        foreach($recipients as $r) {
            if($r->getName())
                $result .= $r->getName().' ';

            $result .= '<'.$r->getEmailAddress().'>, ';
        }

        return $result;
    }
}