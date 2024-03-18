<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Category;
use App\Http\Resources\Admin\CategoryResource;
use App\Traits\imageValidatorData;
use App\Models\Admin\ImageValidator;
use Illuminate\Support\Facades\DB;
use App\Traits\OemsSettingTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Resourceattributes;
use Illuminate\Support\Facades\Validator; 


class CategoryController extends Controller
{
    use imageValidatorData;
    use OemsSettingTrait;

    public function index(Request $request)
    {
        try {
            $oemCode = $request->input('data.oemCode');
            //$catList = Category::with('images')->get();
            // $catList = Category::join('oems_settings', function ($join) use ($oemCode) {
            //         $join->on(DB::raw("FIND_IN_SET(categories.oemCode, oems_settings.oems)"), '=', DB::raw(1))
            //              ->where('categories.oemCode', '=', $oemCode);
            //     })
            //     ->select('categories.*', 'oems_settings.groupCode')
            //     ->get();
            $catList = Category::all();
            foreach ($catList as $key => $value) {
                 $catList[$key]['groupCode'] = $this->getOemsSettingByOemCode($value['oemCode'])->groupCode;
                 $catList[$key]['userId'] = auth()->id();

            }

            if ($catList) {
                return new CategoryResource($catList);
            } else {
                
                return new CategoryResource(null);
            }
        } catch (\Exception $e) {
           echo $e;
            return new CategoryResource(null);
        }
       
    }

    public function tree(Request $request)
    {
        try {
            $oemCode = $request->input('data.oemCode');
            $categories = Category::whereNull('parent_id')->where('oemCode',$oemCode)->with('images')->get();

            $nestedTrees = [];
            $cnt = 0;
            foreach ($categories as $category) {
                $categories[$cnt]['groupCode'] = $this->getOemsSettingByOemCode($oemCode)->groupCode;
                $userId = auth()->id();
                $categories[$cnt]['userId'] = $userId;
                $nestedTrees[] = $category->nestedTree($oemCode,  $userId,'');
                $cnt++;
            }        

            if ($nestedTrees) {
                return new CategoryResource($nestedTrees);
            } else {
                
                return new CategoryResource(null);
            }
        } catch (\Exception $e) {
           echo $e;
            return new CategoryResource(null);
        }
         
    }

    public function store(Request $request)
    {
        try {
           
            $validator = Validator::make($request->all(), [
                'data.slug' => 'required|unique:categories,slug',
            ]);
            if ($validator->fails()) {
               return new CategoryResource("Slug");
            }
            $categoryData = $request->input('data');
            $categoryData['oemCode'] = "RJ-MM";
            $categoryData['selectedAttributes'] = implode(',', array_column($categoryData['selectedAttributes'], 'id'));
            $catstore = Category::create($categoryData);  

            if ($catstore) {
                return new CategoryResource($catstore);
            } else {
                
                return new CategoryResource(null);
            }
        } catch (\Exception $e) {
          
            return new CategoryResource(null);
        } 
    }

    public function show(Request $request)
    {
        try {
            $requestData = $request->all();
            $categoryId = $requestData['data']['id'] ?? null;
            $oemCode = $requestData['data']['oemCode'] ?? null;
            $category = Category::where('oemCode',$oemCode)->with('images')->find($categoryId);
            $category->groupCode = $this->getOemsSettingByOemCode($category->oemCode)->groupCode;
            $category->userId = auth()->id();
            if ($category) {
                $bannerIamges = array();
                $galleryIamges = array();
                $bannercnt = 0;
                $gallerycnt = 0;
                if(count($category['images'])>0){
                    foreach ($category['images'] as $key => $value) {
                        if($value['image_type'] == 'banner'){
                             $bannerIamges[$bannercnt]['id'] = $value['id'];
                             $bannerIamges[$bannercnt]['src'] = $value['name'];
                             $bannerIamges[$bannercnt]['srcOld'] = $value['name'];
                             $bannercnt++;
                        }else{
                             $galleryIamges[$gallerycnt]['id'] = $value['id'];
                             $galleryIamges[$gallerycnt]['src'] = $value['name'];
                             $galleryIamges[$gallerycnt]['srcOld'] = $value['name'];
                             $gallerycnt++;
                        }
                  }
                }
         
            $category['categoryImage'] = (count($bannerIamges)>0)?$bannerIamges[0]:"";
            $category['galleryImages'] =  (count($galleryIamges)>0)?$galleryIamges:"";
            if(count($bannerIamges) == 0){
                 $bannerIamges['id'] ="";
                 $bannerIamges['src'] = "";
                 $bannerIamges['srcOld'] = "";
                 $category['categoryImage'] = $bannerIamges;
            }
            if(count($galleryIamges) == 0){
                 $galleryIamges[0]['id'] ="";
                 $galleryIamges[0]['src'] = "";
                 $galleryIamges[0]['srcOld'] = "";
                 $category['galleryImages'] = $galleryIamges;
            }
            unset($category['images']);
            $attributeArray = explode(',',$category['selectedAttributes']);
            $attributes=array();
            $valco = 0;
            foreach ($attributeArray as $key1 => $value1) {
              $attributesval = Resourceattributes::find($value1);
              if($attributesval){
                 $attributes[$valco]['id'] = $value1;
                 $attributes[$valco]['label'] = $attributesval['attributeName'];
                 $attributes[$valco]['attributeFields'] = $attributesval['attributeFields'];
                 $valco ++;
              }             
             }
             $category->selectedAttributes = $attributes;
             return new CategoryResource($category);
            } else {
                
                return new CategoryResource(null);
            }
        } catch (\Exception $e) {echo $e;
            return new CategoryResource(null);
        } 
    }

    public function update(Request $request)
    {
        try {          
            $requestData = $request->input('data');
            $categoryId = $requestData['id'] ?? null;
            $validator = Validator::make($request->all(), [
                'data.slug' => 'required|unique:categories,slug,'.$categoryId,
            ]);
            if ($validator->fails()) {
               return new CategoryResource("Slug");
            }
            $category = Category::find($categoryId);

            if ($category) {
                $requestData['selectedAttributes'] = implode(',', array_column($requestData['selectedAttributes'], 'id'));
                $category->update($requestData);
                return new CategoryResource("Saved");
            } else {
                
                return new CategoryResource(null);
            }
        } catch (\Exception $e) {
           echo $e;die;
            return new CategoryResource(null);
        } 
    }

    public function destroy(Request $request)
    {        
         try {
                $requestData = $request->all();
                $categoryId = $requestData['data']['id'] ?? null;
                $category = Category::find($categoryId);

                if ($category) {
                        $requestData = $request->all();
                        $categoryId = $requestData['data']['id'] ?? null;
                        $category = Category::find($categoryId);

                        if ($category) {
                            $category->delete();
                            return new CategoryResource("Deleted");
                        } else {
                            
                            return new CategoryResource(null);
                        }

                    return new CategoryResource("Deleted");
                } else {
                    return new CategoryResource(null);
                }
            } catch (\Exception $e) {echo $e;die;
                return new CategoryResource(null);
            } 
    }

    public function listTags(Request $request)
    {
        try {
            $oemCode = $request->input('data.oemCode');
            $categories = Category::where('oemCode',$oemCode)->get();
            $allTags = [];
            foreach ($categories as $category) {
                //$tags = explode(',', $category->selectedTags);
                if($category->selectedTags != null && count($category->selectedTags) > 0){
                    foreach ($category->selectedTags as $tag) {
                        if($tag){
                             $allTags[] = ['id' => $tag, 'label' => $tag];
                         }                   
                    }
                }
                
            }
            if ($allTags) {
                return new CategoryResource($allTags);
            } else {
                
                return new CategoryResource($allTags);
            }
        } catch (\Exception $e) {
          
            return new CategoryResource(null);
        }
        
    }

    public function producttree(Request $request)
    {
        try {
            $catgeoryId = "";
            $oemCode = $request->input('data.oemCode');
            if(null !==  $request->input('data.catgeoryId')){
                $catgeoryId = $request->input('data.catgeoryId');
            }
            if($catgeoryId){
                $categories = Category::where('id',$catgeoryId)->where('oemCode', $oemCode)->with('images')->get();
            }else{
                $categories = Category::whereNull('parent_id')->where('oemCode',$oemCode)->with('images')->get();
            } 
            $nestedTrees = [];
            $cnt = 0;
            foreach ($categories as $category) {
                $categories[$cnt]['groupCode'] = $this->getOemsSettingByOemCode($oemCode)->groupCode;
                $userId = auth()->id();
                $categories[$cnt]['userId'] = $userId;
                $nestedTrees[] = $category->nestedTree($oemCode,  $userId,'product');
                $cnt++;
            }        

            if ($nestedTrees) {
                return new CategoryResource($nestedTrees);
            } else {
                
                return new CategoryResource(null);
            }
        } catch (\Exception $e) {
           echo $e;
            return new CategoryResource(null);
        }
         
    }
}