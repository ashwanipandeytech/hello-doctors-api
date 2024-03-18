<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ImageValidator;
use App\Http\Resources\Admin\ImagevalidatorResource;
use App\Traits\imageValidatorData;

class ImageValidatorController extends Controller
{
    use imageValidatorData;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $imageValidationData =  ImageValidator::all();
        $imageValidations = array();
        foreach ($imageValidationData as $key => $value) {
            $filesValue = explode(',', $value['fileName']);
            foreach ($filesValue as $fkey => $fvalue) {
                $imageValidations[$value['moduleName']][$fvalue] =   ImageValidatorData::selectSettings($fvalue,'')[0];
            }
        }
        return new ImagevalidatorResource($imageValidations); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
