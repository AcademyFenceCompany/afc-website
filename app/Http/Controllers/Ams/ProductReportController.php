<?php

namespace App\Http\Controllers\Ams;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\ams\ProductReports;
use App\Models\Products;
use App\Models\ams\ActivityLog;

class ProductReportController extends Controller
{

    //This is the controller for the product report
    public function index(){
        $id = 45; // Default category id
        // Get list of unique counties
        $categoryqry = \DB::table('categoriesqry')->where('enabled', 1)->select('id','cat_name', 'maj_cat_name')->get();
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->orderBy('cat_name', 'asc')->get();
        $subCategories = \DB::table('categories')->where('active', 1)->orderBy('cat_name', 'asc')->get();

        $productsOb = new ProductReports(); //getAllProducts();
        $arr = $productsOb->getProductsBySubCategoryV2($id);//->take(10);
        $products = $arr['products'];
        $columnHeaders = $productsOb->setTableHeaders($id); // Set Table Headers based on the category id
        // List of filters
        $filters = $arr['filters'];
        // Call the activity log model
        $activityLog = new ActivityLog();
        $activityLog->createLog([
            'note_desc' => 'Product report viewed',
            'filename' => '',
            'ip_info' => request()->ip(),
            'users_id' => 73, //auth()->user()->id,
            'logtype_id' => 1
        ]);

        // List of install jobs
        //$installGallery = \DB::table('product_report')->get();

        return view('ams.product-report', compact('categoryqry','majCategories', 'products', 'subCategories', 'filters', 'columnHeaders', 'id'));
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

    // This function is used to get a list of subcategories by majorcategory id
    public function getCategoryById($id){
        $subCategories = \DB::table('categories')
            ->where('active', 1)
            ->where('majorcategories_id', $id)->orderBy('cat_name', 'asc')
            ->get();
        return view('ams.subcat-list', compact('subCategories'));
    }
    // This function is used to get products by a search string
    public function getProductBySearch($str){
        $categoryqry = \DB::table('categoriesqry')->where('enabled', 1)->select('id','cat_name', 'maj_cat_name')->get();
        $products = \DB::table('products')
            ->where(function($query) use ($str) {
                $query->where('product_name', 'like', '%'.$str.'%')
                      ->orWhere('item_no', 'like', '%'.$str.'%');
            })->get();
            // List of filters
        $filters = array();
        $productsOb = new ProductReports();
        if (!$products->isEmpty()) {
            $firstProduct = $products->first();
            $columnHeaders = $productsOb->setTableHeaders($firstProduct->categories_id); // Set Table Headers based on the category id of the first product
        } else {
            $columnHeaders = $productsOb->setTableHeaders(); // Set default Table Headers
        }
        $id = 45;
        return view('components.product-report', compact('products', 'columnHeaders', 'categoryqry','filters', 'id'));
    }
    // This function is used to get products by their filter
    public function getProductByFilter(Request $request){
        $size1 = $request->post('size',[]);
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
        // Filter by category if selected
        $filters = array_filter($request->only(['size', 'size2', 'size3', 'color', 'style', 'spacing', 'speciality', 'coating', 'material']), function ($value) {
            return !empty($value);
        });
        $productsQuery = \DB::table('products');

        foreach ($filters as $key => $values) {
            if (!empty($values)) {
            $productsQuery->whereIn($key, $values);
            }
        }

        $products = $productsQuery->get();

        $productsOb = new ProductReports();

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
        // List of install jobs
        //$installGallery = \DB::table('product_report')->get();

        return view('components.product-report', compact('products', 'filters', 'columnHeaders', 'id', 'categoryqry','size1', 'size2', 'size3', 'style', 'spacing', 'speciality', 'coating', 'material'));

    }
    // This function is used to edit a product
    public function getById($id){
        $subCategories = \DB::table('categories')->where('active', 1)->orderBy('cat_name', 'asc')->get();
        $product = \DB::table('products')
            ->where('id', $id)
            ->first();
        $productsOb = new Products();
        $size = $productsOb->uniqueValsColumn($product->categories_id, 'size');
        $size2 = $productsOb->uniqueValsColumn($product->categories_id, 'size2');
        $size3 = $productsOb->uniqueValsColumn($product->categories_id, 'size3');
        $color = $productsOb->uniqueValsColumn($product->categories_id, 'color');
        $style = $productsOb->uniqueValsColumn($product->categories_id, 'style');
        $spacing = $productsOb->uniqueValsColumn($product->categories_id, 'spacing');
        $speciality = $productsOb->uniqueValsColumn($product->categories_id, 'speciality');
        $coating = $productsOb->uniqueValsColumn($product->categories_id, 'coating');
        $material = $productsOb->uniqueValsColumn($product->categories_id, 'material');
        return view('components.product-report-edit', compact('product', 'subCategories','size', 'size2', 'size3', 'color', 'style', 'spacing', 'speciality', 'coating', 'material'));
    }
    // This function is used to update a product
    public function update(Request $request){
        $id = $request->post('id');
        $product = Products::findOrFail($id); // Use the Product model to find the product
        $data = $request->except(['_token', '_method']); // Exclude _token and _method fields
        $data['shippable'] = $request->has('shippable') ? 1 : 0; // Convert shippable to 1 or 0
        $data['enabled'] = $request->has('enabled') ? 1 : 0; // Convert enabled to 1 or 0
        // Validate the request
        $request->validate([
            'product_name' => 'required|string|max:255',
            'item_no' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'size2' => 'required|string|max:255',
            'size3' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'style' => 'nullable|string|max:255',
            'spacing' => 'nullable|string|max:255',
            'speciality' => 'nullable|string|max:255',
            'coating' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'shippable' => 'nullable|boolean',
            'enabled' => 'nullable|boolean',
            'categories_id' => 'required|integer|exists:categories,id',
            'img_large' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
            'img_small' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
            // Add other validation rules as needed
        ]);
        // Check if the image is uploaded
        if ($request->hasFile('img_large')) {
            // Get the uploaded file
            $file = $request->file('img_large');
            // Create a new filename
            $filename = time() . '.' . $file->getClientOriginalExtension();
            // Save the image to the public directory
            Image::make($file)->resize(300, 300)->save(public_path('images/products/' . $filename));
            // Set the image path in the data array
            $data['img_large'] = 'images/products/' . $filename;
        } else {
            // If no image is uploaded, keep the old image path
            $data['img_large'] = $product->img_large;
        }
        // Update the product using the model
        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully.'
        ]);
    }

}
