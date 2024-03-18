<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Product;
use Illuminate\Support\Facades\DB;
use App\Traits\OemsSettingTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Resourceattributes;
use App\Http\Resources\Admin\ProductResource;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Imports\CatgeoryImport;
use App\Models\Admin\ProductImage;
use Illuminate\Support\Facades\Validator; 



class ProductController extends Controller
{
    use OemsSettingTrait;
    public function index(Request $request)
    {
         try {
            $oemCode = $request->input('data.oemCode');
            $productList = Product::with(['categories' => function ($query) {
                                $query->select('id', 'name'); // Replace 'other_field' with the field names you need
                            }])
                    ->where('oemCode', $oemCode)
                    ->orderBy('created_at', 'desc')
                    ->get(['id', 'name', 'oemCode','created_at','updated_at','oemCode','productBrand','slug','SKU','tags','stockPrice','mrp','basePrice','isActive','isCoupon','isVariable','isFeatured','isPopular','similarProducts','reviews']);
            foreach ($productList as $key => $value) {
                 if(isset($value['categories'][0]['id'])){
                     $productList[$key]['category_id'] = $value['categories'][0]['id'];
                     $productList[$key]['category_name'] = $value['categories'][0]['name'];
                 }                
                 $productList[$key]['groupCode'] = $this->getOemsSettingByOemCode($value['oemCode'])->groupCode;
                 $productList[$key]['userId'] = auth()->id();
                 $productList[$key]['similarProducts'] = ($value['similarProducts'] != null)?$this->getSimilarProductsAttribute($value['similarProducts'],$oemCode) : null;
                 $productList[$key]['reviews'] = $value['reviews'];
                 unset($productList[$key]['categories']);
            }

            if ($productList) {
                return new ProductResource($productList);
            } else {
                
                return new ProductResource(null);
            }
        } catch (\Exception $e) {
      
            return new ProductResource(null);
        }
    }

    public function store(Request $request)
    {
         try {
            $validator = Validator::make($request->all(), [
                'data.slug' => 'required|unique:products,slug',
            ]);
            if ($validator->fails()) {
               return new ProductResource("Slug");
            }
            if(isset($productData['price'])){
                $productData['price'] = 0.00;
            }
            $productstore = Product::create($productData);  
            $categoryIdsFromRequest = explode(',', $request->input('data.category_id'));
            if ($productstore) {

                if($categoryIdsFromRequest[0]){
                    foreach ($categoryIdsFromRequest as $categoryId) {
                        if (($categoryId) !='') {
                            $newCategoryIds[] = $categoryId;
                            }
                        }               
                       if (count($newCategoryIds) > 0) {
                                $productstore->categories()->attach($newCategoryIds);
                       }
                }
                $productImages = explode(',', $request->input('data.imageUrls'));
                    if($productImages[0]){
                        foreach ($productImages as $prodImage) {
                            if (($prodImage) !='') {
                                  ProductImage::create([
                                        'product_id' => $productstore->id,
                                        'name' =>  $prodImage,
                                        'image_path' => $prodImage,
                                        'image_type' => 'externalimage',
                                    ]);
                                }
                            }
                    }
                if(count($productData['allVariations']) >0){
                    $createdVariations =  $productstore->createVariations($productData['allVariations']);
                    $itcnt = 0;
                    $itemVarArr = array();
                    foreach ($createdVariations as $ivkey => $ivvalue) {
                        $variations = json_decode($ivvalue->variatioons, true);

                        // Remove combinationName from the array
                        unset($variations->combinationName); 

                        // Add additional attributes to the variations array
                        $variations['id'] = $ivvalue->id;
                        $variations['product_id'] = $ivvalue->product_id;
                        $variations['oemCode'] = $ivvalue->oemCode;
                        $variations['combinationName'] = $ivvalue->itemVariationName;
                        $variations['variationSKU'] = $ivvalue->variationSKU;
                        $variations['variationPrice'] = $ivvalue->variationPrice;
                        $variationImages = array(); 
                        $itemVarArr[$itcnt] =  $variations;
                        $itcnt++;
                    }

                    // Assign the modified variations array to the allVariations attribute
                    $productstore['allVariations'] = $itemVarArr;
                    unset($productstore['itemvariation']);
                }               
                
                return new ProductResource($productstore);
            } else {
                 echo $e;
                return new ProductResource(null);
            }
        } catch (\Exception $e) {
          echo $e;
            return new ProductResource(null);
        } 
    }

    public function show(Request $request)
    {
         try {
            $oemCode = $request->input('data.oemCode');
            $id = $request->input('data.id');
            $bannerIamges = array();
            $galleryIamges = array();
            
            $productList = Product::with(['categories' => function ($query) {
                                $query->select('id', 'name');
                            }])
                    ->with('images')
                    ->with('itemvariation.images')
                    ->where('oemCode', $oemCode)
                    ->find($id);
            if ($productList) {               
                 if(isset($productList['categories'][0]['id'])){
                     $productList['category_id'] = $productList['categories'][0]['id'];
                 } 
                $productList['groupCode'] = $this->getOemsSettingByOemCode($productList['oemCode'])->groupCode;
                $productList['userId'] = auth()->id();
                 unset($productList['categories']);
                $productList['similarProducts'] =($productList['similarProducts'] != null)?$this->getSimilarProductsAttribute($productList['similarProducts'],$oemCode) : null;
                $productList['reviews'] = $productList['reviews'];
                $bannercnt = 0;
                $gallerycnt = 0;
                if(count($productList['images'])>0){
                    foreach ($productList['images'] as $key => $value) {
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
                
                $productList['productImage'] = (count($bannerIamges)>0)?$bannerIamges[0]:"";
                $productList['galleryImages'] = (count($galleryIamges)>0)?$galleryIamges:""; 
                 if(count($bannerIamges) == 0){
                         $bannerIamges['id'] ="";
                         $bannerIamges['src'] = "";
                         $bannerIamges['srcOld'] = "";
                         $productList['productImage'] = $bannerIamges;
                }
                $galleryIamgesCount = count($galleryIamges);
                if($galleryIamgesCount == 0){
                    $j = 2;
                }else{
                    $j=3;
                }
                for ($i=$galleryIamgesCount; $i <=($j-$galleryIamgesCount) ; $i++) { 

                         $galleryIamges[$i]['id'] ="";
                         $galleryIamges[$i]['src'] = "";
                         $galleryIamges[$i]['srcOld'] = "";
                }         
                $productList['galleryImages'] = $galleryIamges;
                unset($productList['images']);
                if ($productList->itemvariation) {
                    $itcnt = 0;
                    $itemVarArr = array();
                    foreach ($productList->itemvariation as $ivkey => $ivvalue) {
                        $variations = json_decode($ivvalue->variatioons, true);

                        // Remove combinationName from the array
                        unset($variations->combinationName); 

                        // Add additional attributes to the variations array
                        $variations['id'] = $ivvalue->id;
                        $variations['product_id'] = $ivvalue->product_id;
                        $variations['oemCode'] = $ivvalue->oemCode;
                        $variations['combinationName'] = $ivvalue->itemVariationName;
                        $variations['variationSKU'] = $ivvalue->variationSKU;
                        $variations['variationPrice'] = $ivvalue->variationPrice;
                        $variationImages = array(); 
                        if(count($ivvalue->images)>0){
                            $vicnt = 0;

                            foreach ($ivvalue->images as $ivvimagekey => $ivvvaluevalue) {
                                     $variationImages[$vicnt]['id'] = $ivvvaluevalue['id'];
                                     $variationImages[$vicnt]['src'] = $ivvvaluevalue['name'];
                                     $variationImages[$vicnt]['srcOld'] = $ivvvaluevalue['name'];
                                     $vicnt++;
                              }
                        }
                        $variationImagesCount = count($variationImages);
                        if($variationImagesCount == 0){
                            $j = 2;
                        }else{
                            $j=3;
                        }
                        for ($i=$variationImagesCount; $i <=($j-$variationImagesCount) ; $i++) { 

                                 $variationImages[$i]['id'] ="";
                                 $variationImages[$i]['src'] = "";
                                 $variationImages[$i]['srcOld'] = "";
                        }         
                        $variations['variationImages'] = (count($variationImages)>0)?$variationImages:"";
                        $itemVarArr[$itcnt] =  $variations;
                        $itcnt++;
                    }

                    // Assign the modified variations array to the allVariations attribute
                    $productList['allVariations'] = $itemVarArr;
                    unset($productList['itemvariation']);
                }
            }
           
            if ($productList) {
                return new ProductResource($productList);
            } else {
                
                return new ProductResource(null);
            }
        } catch (\Exception $e) {
    
            return new ProductResource(null);
        }
    }

    public function update(Request $request)
    {
       try {

            $requestData = $request->input('data');
            $productId = $requestData['id'] ?? null;
            $oemCode = $requestData['oemCode'] ?? null;
            $validator = Validator::make($request->all(), [
                'data.slug' => 'required|unique:products,slug,' . $productId, 
            ]);
            if ($validator->fails()) {
               return new ProductResource("Slug");
            }
           
            $categoryIdsFromRequest = explode(',', $request->input('data.category_id'));
            $product = Product::where('oemCode', $oemCode)->find($productId);
            if ($product) {
                if($requestData['videoType'] != 'manual' && $requestData['videosrc'] !=''){      

                    $videoPath = public_path($product->videosrc);
                    if (file_exists($videoPath)) {
                       unlink($videoPath);
                    }
                }
                $product->update($requestData);
                $productImages = explode(',', $request->input('data.imageUrls'));
                if($productImages[0]){
                        $productimagesval = ProductImage::where('product_id', $productId)->delete();
                        foreach ($productImages as $prodImage) {
                            if (($prodImage) !='') {
                                  ProductImage::create([
                                        'product_id' => $productId,
                                        'name' =>  $prodImage,
                                        'image_path' => $prodImage,
                                        'image_type' => 'externalimage',
                                    ]);
                                }
                            }
                }
                if(count($requestData['allVariations']) >0){
                    $createdVariations = $product->updateVariations($requestData['allVariations']);
                    $itcnt = 0;
                    $itemVarArr = array();
                    foreach ($createdVariations as $ivkey => $ivvalue) {
                        $variations = json_decode($ivvalue->variatioons, true);

                        // Remove combinationName from the array
                        unset($variations->combinationName); 

                        // Add additional attributes to the variations array
                        $variations['id'] = $ivvalue->id;
                        $variations['product_id'] = $ivvalue->product_id;
                        $variations['oemCode'] = $ivvalue->oemCode;
                        $variations['combinationName'] = $ivvalue->itemVariationName;
                        $variations['variationSKU'] = $ivvalue->variationSKU;
                        $variations['variationPrice'] = $ivvalue->variationPrice;
                        $variationImages = array(); 
                        $itemVarArr[$itcnt] =  $variations;
                        $itcnt++;
                    }

                    // Assign the modified variations array to the allVariations attribute
                    $product['allVariations'] = $itemVarArr;
                    unset($product['itemvariation']);
                }
                $existingCategoryIds = $product->categories->pluck('id')->toArray();
                $newCategoryIds = [];
                foreach ($categoryIdsFromRequest as $categoryId) {
                    if (($categoryId) !='') {
                        $newCategoryIds[] = $categoryId;
                    }
                }
                if (count($existingCategoryIds) > 0) {
                        $product->categories()->detach($existingCategoryIds);
               }
               if (count($newCategoryIds) > 0) {
                        $product->categories()->attach($newCategoryIds);
               }                 
             
                return new ProductResource($product);
            } else {
                
                return new ProductResource(null);
            }
        } catch (\Exception $e) {       echo $e;    
            return new ProductResource(null);
        } 
    }

    public function destroy(Request $request)
    {
        try {
                $requestData = $request->all();
                $productId = $requestData['data']['id'] ?? null;
                $product = Product::find($productId);

                if ($product) {
                    $product->delete();
                    return new ProductResource("Deleted");
                } else {
                    
                    return new ProductResource(null);
                }
            } catch (\Exception $e) {
               
                return new ProductResource(null);
          } 
    }

    public function getSimilarProductsAttribute($value,$oemCode)
    {
        $similarProductsArray = $value; // Decoding JSON to an associative array

        $existingIds = Product::where('oemCode',$oemCode)->whereIn('id', collect($similarProductsArray)->pluck('id'))->pluck('id')->toArray();

        $filteredArray = array_filter($similarProductsArray, function ($item) use ($existingIds) {
            return in_array($item['id'], $existingIds);
        });

        $filteredArray = array_values($filteredArray);

        return $filteredArray;
    }

    public function listTags(Request $request)
    {
        try {
            $oemCode = $request->input('data.oemCode');
            $products = Product::where('oemCode',$oemCode)->get();
            $allTags = [];
            foreach ($products as $product) {
                if($product->tags != null && count($product->tags) > 0){
                    foreach ($product->tags as $tag) {
                        if($tag){
                             $allTags[] = ['id' => $tag, 'label' => $tag];
                         }                   
                    }
                }
                
            }
            if ($allTags) {
                return new ProductResource($allTags);
            } else {
               
                return new ProductResource($allTags);
            }
        } catch (\Exception $e) {
        
            return new ProductResource(null);
        }
        
    }

    public function uploadVideo(Request $request)
    {
         try {
            $requestData = $request->all();
            $productId = $requestData['productCode'] ?? null;
            $product = Product::find($productId);
            $storagePath = "product/videos";
            $path = 'uploads/'.$storagePath;
            $storagePath = public_path('uploads/' . $storagePath);

            $videoFile = $request->file('videosrc');
            $videoFileName = $videoFile->getClientOriginalName();
            $videoFile->move($storagePath, $videoFileName);
            $path = $path.'/'.$videoFileName;
            $product->update([
                    'videoType' => 'manual',
                    'videosrc' =>  $path
                ]);


            if ($product) {
                return new ProductResource("Saved");
            } else {
               
                return new ProductResource(null);
            }
        } catch (\Exception $e) {
        
            return new ProductResource(null);
        }
       

    }

    public function bulkUploadProducts(Request $request)
    {
       $request->validate([
            'data' => 'required|mimes:xlsx,xls',
        ]);

        $excelFile = $request->file('data');
        $categoryId = $request->input('categoryId');
        $oemCode = $request->input('oemCode');
        $showEditor = $request->input('showEditor');

        try {
            if($request->input('type') == 'category'){
                Excel::import(new CategoryImport, $excelFile);
                return new ProductResource("Saved");
            }else{
                Excel::import(new ProductImport($categoryId, $oemCode,$showEditor), $excelFile);
                return new ProductResource("Saved");
            }
            
        } catch (\Exception $e) {echo $e;
            return new ProductResource(null);
        }
     
    }

     public function getdetails(Request $request)
    {
         try {
            $oemCode = $request->input('data.oemCode');
            $id = $request->input('data.id');
            $bannerIamges = array();
            $galleryIamges = array();
            
            $productList = Product::with(['categories' => function ($query) {
                                $query->select('id', 'name');
                            }])
                    ->with('images')
                    ->with('itemvariation.images')
                    ->where('oemCode', $oemCode)
                    ->find($id);
            if ($productList) {               
                 if(isset($productList['categories'][0]['id'])){
                     $productList['category_id'] = $productList['categories'][0]['id'];
                 } 
                $productList['groupCode'] = $this->getOemsSettingByOemCode($productList['oemCode'])->groupCode;
                $productList['userId'] = auth()->id();
                 unset($productList['categories']);
                $productList['similarProducts'] =($productList['similarProducts'] != null)?$this->getSimilarProductsAttribute($productList['similarProducts'],$oemCode) : null;
                $productList['reviews'] = $productList['reviews'];
                $bannercnt = 0;
                $gallerycnt = 0;
                if(count($productList['images'])>0){
                    foreach ($productList['images'] as $key => $value) {
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
                
                $productList['productImage'] = (count($bannerIamges)>0)?$bannerIamges[0]:"";
                $productList['galleryImages'] = (count($galleryIamges)>0)?$galleryIamges:""; 
                 if(count($bannerIamges) == 0){
                         $bannerIamges['id'] ="";
                         $bannerIamges['src'] = "";
                         $bannerIamges['srcOld'] = "";
                         $productList['productImage'] = $bannerIamges;
                }
                $galleryIamgesCount = count($galleryIamges);
                if($galleryIamgesCount == 0){
                    $j = 2;
                }else{
                    $j=3;
                }
                for ($i=$galleryIamgesCount; $i <=($j-$galleryIamgesCount) ; $i++) { 

                         $galleryIamges[$i]['id'] ="";
                         $galleryIamges[$i]['src'] = "";
                         $galleryIamges[$i]['srcOld'] = "";
                }         
                $productList['galleryImages'] = $galleryIamges;
                unset($productList['images']);
                if ($productList->itemvariation) {
                    $itcnt = 0;
                    $itemVarArr = array();
                    foreach ($productList->itemvariation as $ivkey => $ivvalue) {
                        $variations = json_decode($ivvalue->variatioons, true);

                        // Remove combinationName from the array
                        unset($variations->combinationName); 

                        // Add additional attributes to the variations array
                        $variations['id'] = $ivvalue->id;
                        $variations['product_id'] = $ivvalue->product_id;
                        $variations['oemCode'] = $ivvalue->oemCode;
                        $variations['combinationName'] = $ivvalue->itemVariationName;
                        $variations['variationSKU'] = $ivvalue->variationSKU;
                        $variations['variationPrice'] = $ivvalue->variationPrice;
                        $variationImages = array(); 
                        if(count($ivvalue->images)>0){
                            $vicnt = 0;

                            foreach ($ivvalue->images as $ivvimagekey => $ivvvaluevalue) {
                                     $variationImages[$vicnt]['id'] = $ivvvaluevalue['id'];
                                     $variationImages[$vicnt]['src'] = $ivvvaluevalue['name'];
                                     $variationImages[$vicnt]['srcOld'] = $ivvvaluevalue['name'];
                                     $vicnt++;
                              }
                        }
                        $variationImagesCount = count($variationImages);
                        if($variationImagesCount == 0){
                            $j = 2;
                        }else{
                            $j=3;
                        }
                        for ($i=$variationImagesCount; $i <=($j-$variationImagesCount) ; $i++) { 

                                 $variationImages[$i]['id'] ="";
                                 $variationImages[$i]['src'] = "";
                                 $variationImages[$i]['srcOld'] = "";
                        }         
                        $variations['variationImages'] = (count($variationImages)>0)?$variationImages:"";
                        $itemVarArr[$itcnt] =  $variations;
                        $itcnt++;
                    }

                    // Assign the modified variations array to the allVariations attribute
                    $productList['allVariations'] = $itemVarArr;
                    unset($productList['itemvariation']);
                }
            }
           
            if ($productList) {
                return new ProductResource($productList);
            } else {
                
                return new ProductResource(null);
            }
        } catch (\Exception $e) {
    
            return new ProductResource(null);
        }
    }

    public function productlist(Request $request)
    {
         try {
            $oemCode = $request->input('data.oemCode');
            $type = $request->input('data.type');
            if($type == 'isFeatured'){
                 $productList = Product::with(['categories' => function ($query) {
                                $query->select('id', 'name'); // Replace 'other_field' with the field names you need
                            },
                         'images' => function ($query) {
                                $query->select('id', 'product_id', 'image_path','name','image_type'); // Adjust this according to your image structure
                            }])
                    ->where('oemCode', $oemCode)
                    ->where('isFeatured', 'Yes')
                    ->orderBy('created_at', 'desc')
                    ->get(['id', 'name', 'oemCode','created_at','updated_at','oemCode','productBrand','slug','SKU','tags','stockPrice','mrp','basePrice','isActive','isCoupon','isVariable','isFeatured','isPopular','similarProducts','reviews']);
            }else if($type == 'isPopular'){
                 $productList = Product::with(['categories' => function ($query) {
                                $query->select('id', 'name'); // Replace 'other_field' with the field names you need
                            },
                         'images' => function ($query) {
                                $query->select('id', 'product_id', 'image_path','name','image_type'); // Adjust this according to your image structure
                            }])
                    ->where('oemCode', $oemCode)
                    ->where('isPopular', 'Yes')
                    ->orderBy('created_at', 'desc')
                    ->get(['id', 'name', 'oemCode','created_at','updated_at','oemCode','productBrand','slug','SKU','tags','stockPrice','mrp','basePrice','isActive','isCoupon','isVariable','isFeatured','isPopular','similarProducts','reviews']);
            }else{
                 $productList = Product::with(['categories' => function ($query) {
                                $query->select('id', 'name'); // Replace 'other_field' with the field names you need
                            },
                         'images' => function ($query) {
                                $query->select('id', 'product_id', 'image_path','name','image_type'); // Adjust this according to your image structure
                            }])
                    ->where('oemCode', $oemCode)
                    ->orderBy('created_at', 'desc')
                    ->get(['id', 'name', 'oemCode','created_at','updated_at','oemCode','productBrand','slug','SKU','tags','stockPrice','mrp','basePrice','isActive','isCoupon','isVariable','isFeatured','isPopular','similarProducts','reviews']);
            }
           
            foreach ($productList as $key => $value) {
                 if(isset($value['categories'][0]['id'])){
                     $productList[$key]['category_id'] = $value['categories'][0]['id'];
                 }                
                 $productList[$key]['groupCode'] = $this->getOemsSettingByOemCode($value['oemCode'])->groupCode;
                 $productList[$key]['userId'] = auth()->id();
                 $productList[$key]['similarProducts'] = ($value['similarProducts'] != null)?$this->getSimilarProductsAttribute($value['similarProducts'],$oemCode) : null;
                 $productList[$key]['reviews'] = $value['reviews'];
                 unset($productList[$key]['categories']);
            }

            if ($productList) {
                return new ProductResource($productList);
            } else {
                
                return new ProductResource(null);
            }
        } catch (\Exception $e) {
      
            return new ProductResource(null);
        }
    }

}
