<?php

namespace App\Observers;

use App\Models\Contact;
use Illuminate\Support\Facades\Cache;

class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     */
    public function created(Contact $contact): void
    {
        Cache::forget('header-phone');
        Cache::forget('footer-contacts');
    }

    /**
     * Handle the Contact "updated" event.
     */
    public function updated(Contact $contact): void
    {
        Cache::forget('header-phone');
        Cache::forget('footer-contacts');
    }

    /**
     * Handle the Contact "deleted" event.
     */
    public function deleted(Contact $contact): void
    {
        Cache::forget('header-phone');
        Cache::forget('footer-contacts');
    }

    /**
     * Handle the Contact "restored" event.
     */
    public function restored(Contact $contact): void
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     */
    public function forceDeleted(Contact $contact): void
    {
        //
    }
}
