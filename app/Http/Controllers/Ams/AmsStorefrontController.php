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

        return view('components.product-report', compact('products', 'columnHeaders', 'filters', 'id', 'categoryqry','majCategories', 'subCategories'));
    }
}
