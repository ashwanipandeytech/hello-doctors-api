<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\Systemschema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Traits\httpResponses;
use Illuminate\Support\Collection;


class UploadfilesController extends Controller
{
    use httpResponses;

    public function homejson(Request $request)
    {  
        try {
            $jsonData = $request->input('data');
            $type = $request->input('syncFile');
            $jsonContent = json_encode($jsonData, JSON_PRETTY_PRINT);

            $directoryPath = 'uploads/schemas';

            $fullDirectoryPath = public_path($directoryPath);

            if (!File::isDirectory($fullDirectoryPath)) {
                File::makeDirectory($fullDirectoryPath, 0755, true, true);
            }
            $data = json_decode($jsonContent, true);
            if($type == 'home'){
                   foreach ($data['pageContent'] as &$content) {
                        if ($content['templateID'] === 'SECTION-GRID-BOX-CATEGORIES') {
                             $topLevelCategories = Category::whereNull('parent_id')
                                    ->with(['children' => function ($query) {
                                        $query->select('id', 'name','slug' ,'parent_id');
                                    },
                                     'children.images' => function ($query) {
                                        $query->select('category_id', 'name');
                                    },
                                 'images' => function ($query) {
                                        $query->select('category_id', 'name');
                                    }])
                                                ->select('id', 'name','slug' ,'parent_id')
                                    ->get();
                            $content['data'] = $topLevelCategories;
                        }
                        if ($content['templateID'] === 'SECTION-NEW-PRODUCT') {
                              $newlyAddedProducts = Product::orderBy('created_at', 'desc')
                                                    ->limit(10)
                                                     ->select('id', 'name','productBrand','slug','shortDescription','mrp')
                                                     ->with('images')
                                                    ->get();
                            $content['data'] = $newlyAddedProducts;
                        }
                        if ($content['templateID'] === 'SECTION-DEALS') {
                              $newDeals = Product::where('isDeal','Yes')->orderBy('created_at', 'desc')
                                                    ->limit(10)
                                                    ->select('id', 'name','productBrand','slug','shortDescription','mrp')
                                                    ->with('images')
                                                    ->get();
                            $content['data'] = $newDeals;
                        }
                        if ($content['templateID'] === 'SECTION-SPECIAL-PRODUCTS') {
                                $featureProducts = Product::where('isFeatured','Yes')->orderBy('created_at', 'desc')
                                                    ->limit(10)
                                                    ->select('id', 'name','productBrand','slug','shortDescription','mrp')
                                                    ->with('images')
                                                    ->get();
                                $ispopularProducts = Product::where('isPopular','Yes')->orderBy('created_at', 'desc')
                                                    ->limit(10)
                                                    ->select('id', 'name','productBrand','slug','shortDescription','mrp')
                                                    ->with('images')
                                                    ->get();
                                $bestsellerProducts = Product::where('isBestInSeller','Yes')->orderBy('created_at', 'desc')
                                                    ->limit(10)
                                                    ->select('id', 'name','productBrand','slug','shortDescription','mrp')
                                                    ->with('images')
                                                    ->get();                                        
                            $content['Boxes'][0]['data'] = $featureProducts;
                            $content['Boxes'][1]['data'] = $bestsellerProducts;
                            $content['Boxes'][2]['data'] = $ispopularProducts;
                        }
                    }
            }
            if($type == 'header'){
                    $data = json_decode($jsonContent, true);
                    $categories = Category::whereNull('parent_id')->select('id', 'name', 'slug')->get();
                    $menucnt = count($data['menuItems']);
                    if($categories != ''){
                        $cnt = $menucnt;
                        foreach ($categories as $key => $value) {
                            $data['menuItems'][$cnt]['name'] = $value['name'];
                            $data['menuItems'][$cnt]['slug'] = $value['slug'];
                            $data['menuItems'][$cnt]['id'] = $value['id'];
                            $cnt++;
                        }
                    }
                 
            }


            $modifiedJson = json_encode($data, JSON_PRETTY_PRINT);
            $filePath = $directoryPath . '/'.$type.'.json';

            $fullPath = public_path($filePath);

            if(file_put_contents($fullPath, $modifiedJson)){
                $systemjsons = Systemschema::where('oemCode',$jsonData['oemCode'])->where('featureField',$type)->first();
                if($systemjsons){
                      $systemjsons->update([
                            'featureValue' => $jsonData,
                        ]);
                }else{
                     $one = Systemschema::create([
                        'featureField' =>  $type,
                        'featureValue' =>  $jsonData,
                        'oemCode' =>  $jsonData['oemCode'],
                    ]);
                 }

            }
            return $this->success('','File uploaded successful',200);
        } catch (\Exception $e) {echo $e;
            return $this->error('','File upload fail',401);
        }
     
    }

    public function systemimages(Request $request)
    {  
        try {
            $directoryPath = 'uploads/systemimages';

            $fullDirectoryPath = public_path($directoryPath);

            if (!File::isDirectory($fullDirectoryPath)) {
                File::makeDirectory($fullDirectoryPath, 0755, true, true);
            }

            $systemFile = $request->file('systemimages');
            $systemFileName = $systemFile->getClientOriginalName();
            $systemFile->move($fullDirectoryPath, $systemFileName);
            return $this->success('','File uploaded successful',200);
        } catch (\Exception $e) {
           return $this->error('','File upload fail',401);
        }
     
    }

    public function getsystemimages(Request $request)
    {  
        try {
            $directoryPath = 'uploads/systemimages';

            $fullDirectoryPath = public_path($directoryPath);
            $fileNames = [];

            if (File::isDirectory($fullDirectoryPath)) {
                $files = File::allFiles($fullDirectoryPath);

                foreach ($files as $file) {
                    $fileNames[] = $file->getFilename();
                }
            }
            return $this->success($fileNames,'File uploaded successful',200);
        } catch (\Exception $e) {
           return $this->error('','File Not Found',401);
        }
     
    }

    public function getsystemjsons(Request $request)
    {  
        try {
            $systemjsons = Systemschema::all();
            return $this->success($systemjsons,'',200);
        } catch (\Exception $e) {
           return $this->error('','Data Not Found',401);
        }
     
    }
}
