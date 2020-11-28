<?php

namespace Modules\Item\Imports;

use App\Models\Tenant\Item;
use App\Models\Tenant\Warehouse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Item\Models\Category;
use Modules\Item\Models\Brand;
use Modules\Item\Models\WebPlatform;


class ItemSetImport implements ToCollection
{
    use Importable;

    protected $data;

    public function collection(Collection $rows)
    {
            $total = count($rows);
            $registered = 0;
            unset($rows[0]);
            
            foreach ($rows as $row)
            {
                $description = $row[0];
                $item_type_id = '01';
                $internal_id = ($row[1])?:null;
                $item_code = ($row[2])?:null;
                $unit_type_id = $row[3];
                $currency_type_id = $row[4];
                $sale_unit_price = $row[5];
                $sale_affectation_igv_type_id = $row[6];


                $affectation_igv_types_exonerated_unaffected = ['20','21','30','31','32','33','34','35','36','37'];

                if(in_array($sale_affectation_igv_type_id, $affectation_igv_types_exonerated_unaffected)) {

                    $has_igv = true;

                }else{

                    $has_igv = (strtoupper($row[7]) === 'SI')?true:false;

                }
 
                $category_name = $row[7];
                $brand_name = $row[8];


                if($internal_id) {
                    $item = Item::whereIsSet()->where('internal_id', $internal_id)
                                    ->first();
                } else {
                    $item = null;
                }

                $name = $row[9];
                $second_name = $row[10];
                $web_platform_name = $row[11];

                if(!$item) {

                    $category = Category::updateOrCreate(['name' => $category_name]);
                    $brand = Brand::updateOrCreate(['name' => $brand_name]);
                    $web_platform = WebPlatform::updateOrCreate(['name' => $web_platform_name]);

                    Item::create([
                        'name' => $name,
                        'second_name' => $second_name,
                        'description' => $description,
                        'item_type_id' => $item_type_id,
                        'internal_id' => $internal_id,
                        'item_code' => $item_code,
                        'unit_type_id' => $unit_type_id,
                        'currency_type_id' => $currency_type_id,
                        'sale_unit_price' => $sale_unit_price,
                        'sale_affectation_igv_type_id' => $sale_affectation_igv_type_id,
                        'has_igv' => $has_igv,
                        'purchase_unit_price' => 0,
                        'purchase_affectation_igv_type_id' => $sale_affectation_igv_type_id,
                        'stock' => 0,
                        'stock_min' => 0,
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'web_platform_id' => $web_platform->id,
                        'is_set' => true,
                    ]);

                    $registered += 1;

                }
            }
            $this->data = compact('total', 'registered');

    }

    public function getData()
    {
        return $this->data;
    }
}
