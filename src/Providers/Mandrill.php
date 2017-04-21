<?php

namespace instantjay\emailphp\Providers;

class Mandrill extends Provider {
    private $apiKey;

    public function __construct($apiKey, $defaultSenderEmailAddress, $defaultSenderName)
    {
        parent::__construct($defaultSenderEmailAddress, $defaultSenderName);

        $this->apiKey = $apiKey;
    }

    private function prepareRecipientArray($emailAddress, $name, $type = 'to') {
        $a = [
            'email' => $emailAddress,
            'name' => $name,
            'type' => $type
        ];

        return $a;
    }

    public function send($email) {
        $recipients = [];

        foreach($email->getRecipients() as $r) {
            $recipients[] = $this->prepareRecipientArray($r->getEmailAddress(), $r->getName(), 'to');
        }

        foreach($email->getCCRecipients() as $r) {
            $recipients[] = $this->prepareRecipientArray($r->getEmailAddress(), $r->getName(), 'cc');
        }

        foreach($email->getBCCRecipients() as $r) {
            $recipients[] = $this->prepareRecipientArray($r->getEmailAddress(), $r->getName(), 'bcc');
        }

        $senderEmailAddress = ($email->getSenderEmailAddress() ? $email->getSenderEmailAddress() : $this->defaultSenderEmailAddress);
        $senderName = ($email->getSenderEmailAddress() ? $email->getSenderEmailAddress() : $this->defaultSenderName);

        $message = array(
            "subject" => $email->getSubject(),
            "from_email" => $senderEmailAddress,
            "from_name" => $senderName,
            "to" => $recipients
        );

        if($email->isHTML()) {
            $message['text'] = 'Your e-mail client does not support HTML.';
            $message['html'] = $email->getBody();
        }
        else {
            $message['text'] = $email->getBody();
        }

        if($email->getReplyToEmailAddress()) {
            $message['headers']['Reply-To'] = $email->getReplyToEmailAddress();
        }

        $mandrill = new \Mandrill($this->apiKey);

        try {
            $result = $mandrill->messages->send($message);
        }
        catch(\Mandrill_Error $e) {
            return false;
        }

        foreach($result as $r) {
            if($r["status"] != "sent") {
                // Do something here if an email to one recipient fails.
                return false;
            }
        }

        return $result;
    }
}