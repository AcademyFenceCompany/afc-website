<?php

namespace App\Http\Controllers\Ams;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ams\ProductReports;
use App\Models\Products;
use App\Models\ams\ActivityLog;

class AmsStorefrontController extends Controller
{
    /**
     * Display the AMS Storefront page.
     */

    //This is the controller for the product report
    public function index(){
        $id = 45; // Default category id
        // Get list of unique counties
        $categoryqry = DB::table('categoriesqry')->where('enabled', 1)->select('id','cat_name', 'maj_cat_name')->get();
        $majCategories = DB::table('majorcategories')->where('enabled', 1)->orderBy('cat_name', 'asc')->get();
        $subCategories = DB::table('categories')->where('active', 1)->orderBy('cat_name', 'asc')->get();

        $productsOb = new ProductReports(); //getAllProducts();
        $arr = $productsOb->getProductsBySubCategory($id);//->take(10);
        $products = $arr['products'];
        $columnHeaders = $productsOb->setTableHeaders($id); // Set Table Headers based on the category id
        // List of filters
        $filters = $arr['filters'];
        //@dump($filters, $columnHeaders);
        // Call the activity log model
        // $activityLog = new ActivityLog();
        // $activityLog->createLog([
        //     'note_desc' => 'Product report viewed',
        //     'filename' => '',
        //     'ip_info' => request()->ip(),
        //     'users_id' => 73, //auth()->user()->id,
        //     'logtype_id' => 1
        // ]);

        // List of install jobs
        //$installGallery = \DB::table('product_report')->get();
        return view('ams.storefront', compact('categoryqry','majCategories', 'products', 'subCategories', 'filters', 'columnHeaders', 'id'));
    }
    // This function is used to get a list of products by category id
    public function getProductsByCategoryId($id = 45){

        $productsOb = new ProductReports();
        $arr = $productsOb->getProductsBySubCategory($id);//->take(10);
        $products = $arr['products'];

        // Get category id
        $categoryqry = \DB::table('categoriesqry')->where('enabled', 1)->select('id','cat_name', 'maj_cat_name')->get();
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->orderBy('cat_name', 'asc')->get();
        $subCategories = \DB::table('categories')->where('active', 1)->where('id', $id)->first();
        // Get list of column headers
        $columnHeaders = $productsOb->setTableHeaders($id);
        // List of filters
        $filters = $arr['filters'];

        return view('ams.storefront', compact('products', 'columnHeaders', 'filters', 'id', 'categoryqry','majCategories', 'subCategories'));
    }
    // This function is used to get products by their filter
    public function getProductByFilter(Request $request){
        $size1 = $request->post('size');
        $size2 = $request->post('size2', []);
        $size3 = $request->post('size3', []);
        $style = $request->post('style', []);
        $spacing = $request->post('spacing', []);
        $color = $request->post('color', []);
        $speciality = $request->post('speciality', []);
        $coating = $request->post('coating', []);
        $material = $request->post('material', []);
        $id = $request->post('cat_id');

        // Get By category id
        $categoryqry = \DB::table('categoriesqry')->where('id', $id)->get();

        // Use string variables from the server for filter keys
        $filterKeys = [
            'size' => 'size',
            'size2' => 'size2',
            'size3' => 'size3',
            'color' => 'color',
            'style' => 'style',
            'spacing' => 'spacing',
            'speciality' => 'speciality',
            'coating' => 'coating',
            'material' => 'material'
        ];

        $filters = [];
        foreach ($filterKeys as $key => $column) {
            $value = $request->post($key, []);
            if (!empty($value)) {
            $filters[$column] = $value;
            }
        }

        $productsQuery = \DB::table('products');

        foreach ($filters as $column => $values) {
            if (!empty($values)) {
            // Ensure $values is always an array
            $valuesArray = is_array($values) ? $values : [$values];
            $productsQuery->whereIn($column, $valuesArray);
            }
        }

        $products = $productsQuery->get();

        $productsOb = new ProductReports();
        //@dd($products);
        $columnHeaders = $productsOb->setTableHeaders($id); // Set Table Headers based on the category id

        $size = $productsOb->filterColumn($id, 'size');
        $size2 = $productsOb->filterColumn($id, 'size2');
        $size3 = $productsOb->filterColumn($id, 'size3');
        $color = $productsOb->filterColumn($id, 'color');
        $style = $productsOb->filterColumn($id, 'style');
        $spacing = $productsOb->filterColumn($id, 'spacing');
        $speciality = $productsOb->filterColumn($id, 'speciality');
        $coating = $productsOb->filterColumn($id, 'coating');
        $material = $productsOb->filterColumn($id, 'material');
        $enabled = $productsOb->filterColumn($id, 'enabled');
        $filters = [
            'size' => ['size' => $size, 'selected' => isset($request->post('size')[0]) ? $request->post('size')[0] : ''],
            'size2' => ['size2' => $size2, 'selected' => isset($request->post('size2')[0]) ? $request->post('size2')[0] : ''],
            'size3' => ['size3' => $size3, 'selected' => isset($request->post('size3')[0]) ? $request->post('size3')[0] : ''],
            'color' => ['color' => $color, 'selected' => isset($request->post('color')[0]) ? $request->post('color')[0] : ''],
            'style' => ['style' => $style, 'selected' => isset($request->post('style')[0]) ? $request->post('style')[0] : ''],
            'spacing' => ['spacing' => $spacing, 'selected' => isset($request->post('spacing')[0]) ? $request->post('spacing')[0] : ''],
            'speciality' => ['speciality' => $speciality, 'selected' => isset($request->post('speciality')[0]) ? $request->post('speciality')[0] : ''],
            'coating' => ['coating' => $coating, 'selected' => isset($request->post('coating')[0]) ? $request->post('coating')[0] : ''],
            'material' => ['material' => $material, 'selected' => isset($request->post('material')[0]) ? $request->post('material')[0] : ''],
            'enabled' =>  ['enabled' => $enabled, 'selected' => isset($request->post('enabled')[0]) ? $request->post('enabled')[0] : ''],
        ];

        return view('components.ams-storefront-prods', compact('products'));

    }
}
