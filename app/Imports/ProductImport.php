<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\ProductImage;

class ProductImport implements ToCollection, WithHeadingRow
{
    protected $categoryId;
    protected $oemCode;
    protected $showEditor;

    public function __construct($categoryId, $oemCode,$showEditor)
    {
        $this->categoryId = $categoryId;
        $this->oemCode = $oemCode;
        $this->showEditor = $showEditor;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
                $rowArray = $row->toArray(); 
               
                  $categoryId = $this->categoryId;
                  $oemCode = $this->oemCode;
                if (!empty(array_filter($rowArray))) {
                        if (Product::where('slug', $rowArray['slug'])->exists()) {
                            continue;
                        }

                    $defaultPriceRange = [
                        [
                            'max' => 0,
                            'min' => 0,
                            'quantity' => 1,
                            'rangePrice' => '',
                        ]
                    ];
                    
                    $defaultReviews = [
                        [
                            'customerName' => '',
                            'reviewDescription' => '',
                        ]
                    ];

                    $attributes = [
                        [
                            'Compatible Devices' => $rowArray['gen_compatibledevices'],
                            'Material' => $rowArray['gen_material'],
                            'Product Dimensions' => $rowArray['gen_productdimensions'],
                            'Compatible Phone Models' => $rowArray['gen_compatiblephonemodels'],
                            'Special Feature' => $rowArray['gen_specialfeature'],
                            'Finish Type' => $rowArray['gen_finishtype'],
                            'Screen Surface Description' => $rowArray['gen_screensurfacedescription'],
                            'Clarity' => $rowArray['gen_clarity'],
                            "combinationName"=> "Variation-General-Info",                          
                        ]
                    ];  

                     $attributestechnical = [
                        [
                            'Product Dimensions' => $rowArray['th_productdimensions'],
                            'Item model number' => $rowArray['th_itemmodelnumber'],
                            'Special features' => $rowArray['th_specialfeatures'],
                            'Colour' => $rowArray['th_colour'],
                            'Whats in the box' => $rowArray['th_whatinthebox'],
                            'Manufacturer' => $rowArray['th_manufacturer'],
                            "combinationName"=>"Variation-Technical-Info",                         
                        ]
                    ];

                     $attributesadditional = [
                        [
                            'ASIN' => $rowArray['ad_asin'],
                            'Best Sellers Rank' => $rowArray['ad_bestsellersrank'],
                            'Date First Available' => $rowArray['ad_datefirstavailable'],
                            'Manufacturer' => $rowArray['ad_manufacturer'],
                            'Product Dimensions' => $rowArray['ad_productdimensions'],
                            "combinationName"=>"Variation-Additional-Info",
                        ]
                    ];                  

                    $productstore = Product::create([
                        'name' => $rowArray['name'],
                        'oemCode' => $this->oemCode,
                        'productBrand' => $rowArray['brand'],
                        'slug' => $rowArray['slug'],
                        'productUnit' => $rowArray['numberofitems'],
                        'productMaxQuantity' => $rowArray['numberofitems'],
                        'shortDescription' => $rowArray['shortdescription'],
                        'longDescription' => $rowArray['longdescription'],
                        'mrp' => $rowArray['mrp'],
                        'price' => $rowArray['mrp'],
                        'basePrice' => $rowArray['mrp'],
                        'isVariable' => 'No',
                        'isFeatured' => 'No',
                        'isActive' => 'No',
                        'isPopular' => 'No',
                        'isCoupon' => 'No',
                        'videoType' => 'Youtube',                        
                        'priceRange' => $defaultPriceRange,
                        'reviews' => $defaultReviews,
                        'isBulkUpload' => 'Yes',
                        'showEditor' => $this->showEditor
                    ]);
                   
                    $productstore->categories()->attach($categoryId);
                    $createdVariations =  $productstore->createVariations($attributes);
                    $createdVariations =  $productstore->createVariations($attributestechnical);
                    $createdVariations =  $productstore->createVariations($attributesadditional);
                    
                    $productImages = explode(',', $rowArray['images']);
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

                }
            }
    }
}

