<?php

namespace App\Mail;

use App\Mail\NotifyMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


class MailService
{
    public function sendEmail($userId, $orderStatus)
    {
        $user = User::find($userId);
        if ($user == null) return "failed";

        //$to = "kmaks1364@gmail.com";
        $to = $user->email;
        
        $details = [
            'title' => 'Order status has changed',
            'body' => '<h3>Your order has status - <b style="color: green;">' . $orderStatus . '</b><h3/>'
        ];

       Mail::to($to)->send(new NotifyMail($details));

        return 'sent';
    }
}