<?php

namespace App\Console\Commands\Email;

use App\Mail\TestEmail;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'email:test {email}';
    protected $description = 'Sending a test message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        try {
            Mail::to($email)->send(new TestEmail());
        } catch (Exception $e) {
            Log::error('Помилка з відправкою повідомлення: '.$e->getMessage());
        }

        $this->info('Повідомлення успішно відправлено');
    }
}
