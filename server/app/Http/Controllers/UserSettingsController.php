<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserSettingsRequest;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    public function show(Request $request)
    {
        $user_id = $request->user()->id;

        $settings = UserSetting::where('user_id', $user_id)->first();

        return response()->json([
            'message' => 'User settings returned successfully',
            'settings' => $settings->settings
        ], 200);
    }

    public function update(UpdateUserSettingsRequest $request)
    {
        $user_id = $request->user()->id;

        $settings = [
            'fav_categories' => $request->fav_categories ?? [],
            'fav_sources' => $request->fav_sources ?? [],
            'fav_authors' => $request->fav_authors ?? []
        ];

        UserSetting::where('user_id', $user_id)
            ->update([
                'settings' => $settings
            ]);

        return response()->json([
            'message' => 'User settings updated successfully',
            'settings' => $settings
        ], 200);
    }

}
