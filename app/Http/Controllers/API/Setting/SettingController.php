<?php

namespace App\Http\Controllers\API\Setting;

use App\Helper\Helper;
use App\Http\Controllers\API\ApiController;
use App\Models\AppSettings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends ApiController
{
   public function getHelpURL() {
        $helpURI = AppSettings::where('setting_key','help_url')->firstOrFail();
        return response()->json([
            'data' => $helpURI,
            'success' => true
        ]);
    }
    public function getForgotURL() {
        $forgotURI = AppSettings::where('setting_key','forgot_url')->firstOrFail();
        return response()->json([
            'data' => $forgotURI,
            'success' => true
        ]);
    }

     public function notRecordPurchase() {
        $notRecordForm = AppSettings::where('setting_key','not_recorded_embed')->firstOrFail();
        return response()->json([
            'data' => $notRecordForm,
            'success' => true
        ]);
    }
    public function appSettings(Request $request) {
        //Helper::sendSingleNotification(); //testing notification from backend
        $includes = explode(',', $request->key);
        foreach ($includes as $key){
            $settingsValues[] = AppSettings::where('setting_key',$key)->first();
        }
        return response()->json([
            'data' => $settingsValues,
            'success' => true
        ]);
    }
}
