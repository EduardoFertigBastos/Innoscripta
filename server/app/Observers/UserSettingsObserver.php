<?php

namespace App\Observers;

use App\Models\UserSetting;

class UserSettingsObserver
{
    public function retrieved(UserSetting $model)
    {
        $model->settings = json_decode($model->settings);
    }

    /**
     * Handle the UserSetting "created" event.
     */
    public function created(UserSetting $userSettings): void
    {
        //
    }

    /**
     * Handle the UserSetting "updated" event.
     */
    public function updated(UserSetting $userSettings): void
    {
        //
    }

    /**
     * Handle the UserSetting "deleted" event.
     */
    public function deleted(UserSetting $userSettings): void
    {
        //
    }

    /**
     * Handle the UserSetting "restored" event.
     */
    public function restored(UserSetting $userSettings): void
    {
        //
    }

    /**
     * Handle the UserSetting "force deleted" event.
     */
    public function forceDeleted(UserSetting $userSettings): void
    {
        //
    }
}
