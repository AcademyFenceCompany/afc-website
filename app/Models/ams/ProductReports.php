<?php

namespace App\Models\ams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReports extends Model
{
    use HasFactory;
    protected $table = 'products';
    // Product Filter array columns
    public $productFilter = [
        'size' => 'Size',
        'size2' => 'Size2',
        'size3' => 'Size3',
        'color' => 'Color',
        'list' => 'List',
        'style' => 'Style',
        'spacing' => 'Spacing',
        'speciality' => 'Specialty',
        'coating' => 'Coating',
        'material' => 'Material',
        'enabled' => 'Enabled',
    ];
    // This function is used to get the product report
    public function getProductById($id){
        return \DB::table('products')
            ->where('id', $id)
            ->first();
    }
    // This function is used to get a list of all products
    public function getAllProducts(){
        return \DB::table('productsqry')
            ->limit(100)
            ->get();
    }
    // This function is used to get a list of products by category
    public function getProductsByMajorCategory($id){
        return \DB::table('productsqry')
            ->where('majorcategories_id', $id)->limit(10)
            ->get();
    }
    // This function is used to get a list of products by category
    public function getProductsBySubCategory($id){
        $products = \DB::table('productsqry')
            ->where('categories_id', $id)->limit(100)
            ->get();
        $size = $this->filterColumn($id, 'size');
        $size2 = $this->filterColumn($id, 'size2');
        $size3 = $this->filterColumn($id, 'size3');
        $color = $this->filterColumn($id, 'color');
        $style = $this->filterColumn($id, 'style');
        $spacing = $this->filterColumn($id, 'spacing');
        $speciality = $this->filterColumn($id, 'speciality');
        $coating = $this->filterColumn($id, 'coating');
        $material = $this->filterColumn($id, 'material');
        $enabled = $this->filterColumn($id, 'enabled');
        return [
            'products' => $products,
            'filters' => [
                'size' => ['size' => $size, 'selected' => '48in x 50ft'],
                'size2' =>  ['size2' => $size2, 'selected' => '2in x 4in'],
                'size3' => ['size3' => $size3, 'selected' => '14 Gauge'],
                'color' => ['color' => $color, 'selected' => 'Black'],
                'style' => ['style' => $style, 'selected' => ''],
                'spacing' => ['spacing' => $spacing, 'selected' => ''],
                'speciality' => ['speciality' => $speciality, 'selected' => ''],
                'coating' => ['coating' => $coating, 'selected' => 'Vinyl'],
                'material' => ['material' => $material, 'selected' => ''],
                'enabled' => ['enabled' => $enabled, 'selected' => ''],
            ],
        ];
    }
    // This function is used to get a list of products by category: Deprecated
    public function getProductsBySearch($id){
        $products = \DB::table('products')
            ->where(function($query) use ($str) {
                $query->where('product_name', 'like', '%'.$str.'%')
                      ->orWhere('item_no', 'like', '%'.$str.'%');
            })->get();
        $filters = $this->filterColumn($id, 'size');
        return [
            'products' => $products,
            'filters' => $filters,
        ];
    }
    // This function is used to filter products by unique values
    public function filterColumn($id, $filter){
        $filteredValues = \DB::table('products')
            ->where('categories_id', $id)
            ->distinct()
            ->orderBy($filter, 'asc')
            ->pluck($filter)
            ->toArray();

        return $filteredValues;
    }
    // This function is used to set table headers
    public function setTableHeaders($id = 45){
        switch ($id) {
            case 45: // Category: Welded Wire
            $columnHeaders = [
                'size' => 'H/W Roll',
                'size2' => 'Mesh/Gauge',
                'size3' => 'Gauge',
                'color' => 'Color',
                'list' => 'List',
                'style' => 'Style',
                'speciality' => 'Specialty',
                'spacing' => 'Spacing',
                'coating' => 'Galv/Vinyl',
                'material' => 'GAB/GAW',
                'enabled' => 'Enabled',
            ];
            break;
            case 2:
            $columnHeaders = [
                'size' => 'Size',
                'size2' => 'Size2',
                'size3' => 'Size3',
                'color' => 'Color',
                'list' => 'List',
                'style' => 'Style',
                'spacing' => 'Spacing',
                'speciality' => 'Specialty',
                'coating' => 'Coating',
                'material' => 'Material',
                'enabled' => 'Enabled',
            ];
            break;
            case 82: // Wood Post Caps
                $columnHeaders = [
                    'size' => 'Nominal Size',
                    'size2' => 'Cap Opening',
                    'size3' => 'Fits Size',
                    'color' => 'Color',
                    'list' => 'List',
                    'style' => 'Style',
                    'spacing' => 'Spacing',
                    'speciality' => 'Specialty',
                    'coating' => 'Coating',
                    'material' => 'Material',
                    'enabled' => 'Enabled',
                ];
                break;
            case 81: // SOLAR Post Caps
                $columnHeaders = [
                    'size' => 'Nominal Size',
                    'size2' => 'Cap Opening',
                    'size3' => 'Fits Size',
                    'color' => 'Color',
                    'list' => 'List',
                    'style' => 'Style',
                    'spacing' => 'Spacing',
                    'speciality' => 'Specialty',
                    'coating' => 'Coating',
                    'material' => 'Material',
                    'enabled' => 'Enabled',
                ];
                break;
            default:
            $columnHeaders = $this->productFilter;
            break;
        }
        return $columnHeaders;
    }
}
