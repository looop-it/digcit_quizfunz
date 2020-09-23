<?php

namespace App\Observers;

use App\Jobs\Registration\SendSchoolRegistrationConfirmEmail;
use App\Models\SchoolRegistration;

class SchoolRegistrationObserver
{
    /**
     * Handle the School registration "created" event.
     *
     * @param  \App\Models\SchoolRegistration
     * @return void
     */
    public function created(SchoolRegistration $registration)
    {
        //
    }

    /**
     * Handle the School registration "updated" event.
     *
     * @param  \App\Models\SchoolRegistration
     * @return void
     */
    public function updated(SchoolRegistration $registration)
    {
        if ($registration->approved) {
            dispatch(new SendSchoolRegistrationConfirmEmail($registration));
        }
    }

    /**
     * Handle the School registration "deleted" event.
     *
     * @param  \App\Models\SchoolRegistration
     * @return void
     */
    public function deleted(SchoolRegistration $registration)
    {
        //
    }
}
