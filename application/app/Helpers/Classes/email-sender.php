<?php

namespace App\Helpers\Classes;

use Mail;

class EmailSender {

    public static function send($data) {
        try {

            $data['blade'] = 'emails.' . $data['blade'];

            //gettign from address from configuration
            $mailConfig = config('mail.from');

            $data['fromAddress'] = !empty($data['fromAddress']) ? $data['fromAddress'] : $mailConfig['address'];
            $data['fromName'] = !empty($data['fromName']) ? $data['fromName'] : $mailConfig['name'];

            Mail::send($data['blade'], $data['body'], function($message) use ($data) {
                $message->from($data['fromAddress'], $data['fromName']);
                $message->to($data['toUser'], $data['toUserName']);
                $message->subject($data['subject']);
            });

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}