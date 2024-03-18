<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Admin\Category;

class CategoryImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
                $rowArray = $row->toArray(); 
                   if (Product::where('slug', $rowArray['slug'])->exists()) {
                            continue;
                    }
                    Category::create([
                        'name' => $rowArray['name'],
                        'oemCode' => $rowArray['oemcode'],
                        'parent_id' => $rowArray['parent_id'],
                        'slug' => $rowArray['slug'],
                        'seoTitle' => $rowArray['seotitle'],
                        'seoKeywords' => $rowArray['seokeywords'],
                        'seoDescription' => $rowArray['seodescription'],
                        'shortDescription' => $rowArray['shortdescription'],
                        'longDescription' => $rowArray['longdescription'],
                        'isActive' => 'No',
                        'isMenu' => 'No',
                    ]);
                }
            }
    }

