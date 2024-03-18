<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\ResourceattributesResource;
use Illuminate\Support\Facades\Auth;
use App\Traits\OemsSettingTrait;
use App\Models\Admin\Resourceattributes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResourceattributesController extends Controller
{
     use OemsSettingTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $oemCode = $request->input('data.oemCode');
            $data = Resourceattributes::where('oemCode', $oemCode)->get();           
            if ($data) {
                return new ResourceattributesResource($data);
            } else {
                
                return new ResourceattributesResource(null);
            }
        } catch (\Exception $e) {
            return new ResourceattributesResource(null);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $resoourceAttData = $request->input('data');
            $resoourceAttData['oemCode'] = "RJ-MM";
            $resoourceAttData = Resourceattributes::create($resoourceAttData);    
            $resoourceAttData->groupCode = $this->getOemsSettingByOemCode($resoourceAttData->oemCode)->groupCode;
            $resoourceAttData->userId = auth()->id();
            if ($resoourceAttData) {
                return new ResourceattributesResource($resoourceAttData);
            } else {
                
                return new ResourceattributesResource(null);
            }
        } catch (\Exception $e) {
            return new ResourceattributesResource(null);
        } 
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      try {
            $attributeData = $request->input('data');
            $attributeId = $attributeData['id'] ?? null;
            $attributedetails = Resourceattributes::find($attributeId);

            if ($attributedetails) {
                $attributedetails->update($attributeData);
                return new ResourceattributesResource("Saved");
            } else {
                
                return new ResourceattributesResource(null);
            }
        } catch (\Exception $e) {
           
            return new ResourceattributesResource(null);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $attributeData = $request->all();
            $attributeId = $attributeData['data']['id'] ?? null;
            $labelToRemove = $attributeData['data']['attributeFields'] ?? null;
            $attributedetails = Resourceattributes::find($attributeId);
            $data = $attributedetails->attributeFields;
            if ($data) {
                $filteredData = array_filter($data, function ($item) use ($labelToRemove) {
                    return $item['label'] !== $labelToRemove;
                });

                // Update the record in the database with the modified JSON data
                DB::table('resource_attributes')
                    ->where('id', $attributeId)
                    ->update(['attributeFields' => json_encode(array_values($filteredData))]);
                return new ResourceattributesResource("Deleted");
            } else {
                
                return new ResourceattributesResource(null);
            }
        } catch (\Exception $e) {
          echo $e;
            return new ResourceattributesResource(null);
        } 
    }
}
