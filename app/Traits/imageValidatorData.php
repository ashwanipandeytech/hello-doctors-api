<?php
namespace App\Traits;
use App\Models\Admin\ImageValidator;
use Illuminate\Support\Facades\DB;

trait imageValidatorData {
   
    /**
     * Get the image validation settings based on the module name.
     *
     * @param  string  $fileName
     * @param  string  $src
     * @return \Illuminate\Support\Collection
    */
    public static function selectSettings(string $fileName, string $src)
    {
        $query = "
                SELECT CONCAT('image/', IF(type='jpg', 'jpeg', type)) as type, height, width, size, 
                       checkTypeValidation, checkHeightValidation, checkWidthValidation, checkValidation, 
                       chekSizeValidation, ? as src, ? as srcOld 
                FROM imagevalidation 
                WHERE fileName = ?
            ";

        $settings = DB::select($query, [$src, $src, $fileName]);

        return $settings;
    }

}