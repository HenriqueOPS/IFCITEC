<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class MailController extends Controller
{
    public function sendEmail()
    {
        $details = [
            'title' => "IFCITEC - Testando envio de emails",
            'body' => "Se você recebeu esse email, significa que tudo está correto."
        ];

        Mail::to("apvgroll@gmail.com")->send(new TestMail($details));
        return "Email enviado com sucesso!";
    }
}
