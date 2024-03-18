<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ImageUploadTrait;
use App\Models\Product;
use App\Models\Category;
use App\Models\Admin\ProductImage;
use App\Models\Admin\CategoryImage;
use App\Models\Admin\ItemVariationImage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Traits\httpResponses;

class ImageUploadController extends Controller
{
    use ImageUploadTrait,httpResponses;

    public function uploadImage(Request $request)
    {

        $type = $request->input('data.type');
        $imageType = $request->input('data.image_type');
        $folder = match ($type) {
        'category' => match ($imageType) {
            'banner' => 'category',
            'gallery' => 'category/gallery',
            default => null,
        },
        'product' => match ($imageType) {
            'banner' => 'product',
            'gallery' => 'product/gallery',
            default => null,
            },
        'variation' => match ($imageType) {
            'variation' => 'product/variations',
            default => null,
            },    
            default => null,
        };
        
        if(explode(";base64,", $request->input('data.image'))[0] !=''){
             // Call the uploadImage method from the trait to handle image upload
            $imagePath = $this->uploadImages($request->input('data.image'), $folder );

            // Determine the entity type (category or product)
            $entityType = $request->input('data.type');
            $imageType = $request->input('data.image_type');
            $entityId = $request->input('data.entity_id');

            // Save the image information to the corresponding table (ProductImage or CategoryImage)
            if ($entityType === 'category') {
                CategoryImage::where('category_id', $entityId)->delete();
                CategoryImage::create([
                    'category_id' => $entityId,
                    'name' => $imagePath['imageName'],
                    'image_path' => $imagePath['url'],
                    'image_type' => $imageType,
                ]);
            }elseif($entityType === 'product'){
                  ProductImage::create([
                    'product_id' => $entityId,
                    'name' =>  $imagePath['imageName'],
                    'image_path' => $imagePath['url'],
                    'image_type' => $imageType,
                ]);
            } else {
                ItemVariationImage::create([
                    'item_variation_id' => $entityId,
                    'name' =>  $imagePath['imageName'],
                    'image_path' => $imagePath['url'],
                    'image_type' => $imageType,
                ]);
            }
        }
        return $this->success("",'Image uploaded successfully',200);
    }
}

