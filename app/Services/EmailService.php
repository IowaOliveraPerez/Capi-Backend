<?php

namespace App\Services;

use App\Models\Contacto;
use App\Models\Email;

class EmailService
{
    public function updateEmails(Contacto $contacto, array $emails)
    {
        $emailIds = collect($emails)->pluck('id')->filter();
        $contacto->emails()->whereNotIn('id', $emailIds)->delete();
        foreach ($emails as $email) {
            if (isset($email['id'])) {
                Email::where('id', $email['id'])->update(['email' => $email['email']]);
            } else {
                $contacto->emails()->create(['email' => $email['email']]);
            }
        }
    }
}
