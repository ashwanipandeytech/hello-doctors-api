<?php 

namespace App\Traits;

use App\Models\Admin\OemsSetting;
use App\Models\Admin\Oems;

trait OemsSettingTrait
{
    /**
     * Get the OemsSetting record based on oems column.
     *
     * @param  string  $oemCode
     * @return OemsSetting|null
     */
    public function getOemsSettingByOemCode($oemCode)
    {
        return OemsSetting::where('oems', $oemCode)->first();
    }

    public function getOemDetails($oemCode)
    {
        return Oems::where('oemCode', $oemCode)->first();
    }
}
