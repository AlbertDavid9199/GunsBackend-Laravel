<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Product;
use App\Models\Vault;
use App\Models\Product_image;
use App\Models\Manufacture;
use DateTime;

class ProductController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['index', 'dataSave', 'dataDelete', 'dataGetAll', 'dataGetById', 'dataUpdateById', 'dataPublishById']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (JWTAuth::invalidate(JWTAuth::getToken())) {

            $stores_modified = Product::where('user_id', $request->id)->get();

            $stores = array();
            $store;
            foreach ($stores_modified  as $store_modified){
                $store = $store_modified;
                $category = Store_cat::find($store_modified->category_id);
                $store->logo_url = $store_modified->logo_url;
                $store->category = $category->name;
                $stores[] = $store;
            }
            return $stores;

        } else {
            return response()->json(array('status', 1));
        }
    }

    /**=====================================
     *          Product Save
     *======================================*/
    public function dataSave(Request $request) {

        if ($request->isMethod('post')) {

            // if (Product::where('serial_number', $request->input('serial_number'))->count() > 0)
            //     return response()->json(array('error' => 'Product already exists.(same serial number)'));
            
            $credentials = $request->only('user_id', 'manufacture_id', 'name', 'description', 'sku', 'serial_number', 'model', 'barrel_length', 'capacity', 'firing_casing', 'frame_per_material', 'sights', 'user_id', 'product_id', 'stock_number', 'original_stock_number', 'published', 'published_at', 'price', 'original_price');

            $product = new Product;
            $vault = new Vault;
            $candidate = array();

            try {
            
                $product->manufacture_id = $request->input('manufacture_id');
                $product->name = $request->input('name');
                $product->description = $request->input('description');
                $product->sku = $request->input('sku');
                $product->serial_number = $request->input('serial_number');
                $product->product_model = $request->input('product_model');
                $product->barrel_length = $request->input('barrel_length');
                $product->capacity = $request->input('capacity');
                $product->firing_casing = $request->input('firing_casing');
                $product->frame_per_material = $request->input('frame_per_material');
                $product->sights = $request->input('sights');

                $product->save();

                $vault->name = $request->input('name');
                $vault->description = $request->input('description');
                $vault->quantity = $request->input('quantity');
                $vault->sku = $request->input('sku');
                $vault->serial_number = $request->input('serial_number');
                $vault->product_model = $request->input('product_model');
                $vault->barrel_length = $request->input('barrel_length');
                $vault->capacity = $request->input('capacity');
                $vault->firing_casing = $request->input('firing_casing');
                $vault->frame_per_material = $request->input('frame_per_material');
                $vault->sights = $request->input('sights');
                $vault->user_id = $request->input('user_id');
                $vault->product_id = $product->product_id;
                $vault->stock_number = $request->input('stock_number');
                $vault->original_stock_number = $request->input('original_stock_number');
                $vault->published = $request->input('published');
                $vault->published_at = $request->input('published_at');
                $vault->price = $request->input('price');
                $vault->original_price = $request->input('original_price');
                $vault->date = $request->input('date');
                $vault->brand = $request->input('brand');
                $vault->caliber = $request->input('caliber');

                $vault->save();
                $image =  $request->input('image');
                // var_dump($image);
                // exit;
                $destinationPath =  base_path() . '/public/images/products/';

                foreach ($image  as $item){
                    $product_image = new Product_image;
                    $img = str_replace('data:image/jpeg;base64,', '', $item['data']);
                    $data = base64_decode($img);
                    file_put_contents($destinationPath . $item['name'], $data);
                    $product_image->product_id = $product->product_id;
                    $product_image->name = '/images/products/' . $item['name'];
                    $product_image->location = $request->input('location');
                    $product_image->save();
                }

                // echo $product->id;
                // exit;
            } catch (Exception $e) {
               return response()->json(['error' => 'DB error.'], HttpResponse::HTTP_CONFLICT);
            }

            // $token = JWTAuth::fromUser($user);

            // $candidate->email = $request->email;

            // if ($request->image_url){
            //     $candidate->image_url = $request->image_url;   
            // }

            $status = 0;
            return response()->json(compact(['status', 'product', 'vault', 'product_image']));
        } 
        
        
    }
    /**=====================================
     *          Product Delete
     *======================================*/
    public function dataDelete(Request $request) {

        if ($request->isMethod('post')) {

            try {
              
                $vault = Vault::where('product_id', $request->input('product_id'))->first();
                if ($vault->delete()){
                    $status = 0;
                }else{
                    $status = 1;
                }
            } catch (Exception $e) {
               return response()->json(['error' => 'DB error.'], HttpResponse::HTTP_CONFLICT);
            }
            return response()->json(compact(['status']));
        } 
        
        
    }

    /**=====================================
     *          Product Get All
     *======================================*/
    public function dataGetAll(Request $request) {

        if ($request->isMethod('post')) {
            try {
                $vaults = Vault::where('user_id', $request->input('user_id'))->get();

                // foreach ($vaults as $vault) {
                //     $imageObj = new Product_image;
                //     $imageObj = Product_image::where('product_id', $vault->product_id)->first();
                //     $vault->image = $imageObj->name;
                // }
                $products = Product::all();

                $status = 0;
            } catch (Exception $e) {
               return response()->json(['error' => 'DB error.'], HttpResponse::HTTP_CONFLICT);
            }

            return response()->json(compact(['vaults', 'products', 'status']));
        } 
        
        
    }

    /**=====================================
     *          Product Get By Id
     *======================================*/
    public function dataGetById(Request $request) {

        if ($request->isMethod('post')) {

            if (Vault::where('user_id', $request->input('user_id'))->count() < 1)
                return response()->json(array('error' => 'Product not exists.'));

            try {
              $vault = Vault::where('user_id', $request->input('user_id'))->get();

            } catch (Exception $e) {
               return response()->json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
            }

            $status = 0;
            return response()->json(compact(['vault', 'status']));
        } 
        
    }

    /**=====================================
     *          Product Update By Id
     *======================================*/
    public function dataUpdateById(Request $request) {

        if ($request->isMethod('post')) {

            if (Product::where('product_id', $request->input('product_id'))->count() == 0)
                return response()->json(array('error' => 'Product not exists.'));
            
            $product = new Product;
            $vault = new Vault;
            $candidate = array();

            try {
            
                $product = Product::find($request->input('product_id'));
                $product->manufacture_id = $request->input('manufacture_id');
                $product->name = $request->input('name');
                $product->description = $request->input('description');
                $product->sku = $request->input('sku');
                $product->serial_number = $request->input('serial_number');
                $product->product_model = $request->input('product_model');
                $product->barrel_length = $request->input('barrel_length');
                $product->capacity = $request->input('capacity');
                $product->firing_casing = $request->input('firing_casing');
                $product->frame_per_material = $request->input('frame_per_material');
                $product->sights = $request->input('sights');
                $product->save();
                
                $vault = Vault::where('product_id', $product->product_id)->first();
                $vault->name = $request->input('name');
                $vault->description = $request->input('description');
                $vault->quantity = $request->input('quantity');
                $vault->sku = $request->input('sku');
                $vault->serial_number = $request->input('serial_number');
                $vault->product_model = $request->input('product_model');
                $vault->barrel_length = $request->input('barrel_length');
                $vault->capacity = $request->input('capacity');
                $vault->firing_casing = $request->input('firing_casing');
                $vault->frame_per_material = $request->input('frame_per_material');
                $vault->sights = $request->input('sights');
                $vault->user_id = $request->input('user_id');
                $vault->product_id = $product->product_id;
                $vault->stock_number = $request->input('stock_number');
                $vault->original_stock_number = $request->input('original_stock_number');
                $vault->published = $request->input('published');
                $vault->published_at = $request->input('published_at');
                $vault->price = $request->input('price');
                $vault->original_price = $request->input('original_price');
                $vault->date = $request->input('date');
                $vault->brand = $request->input('brand');
                $vault->caliber = $request->input('caliber');

                $vault->save();
                $image = array();
                $image =  $request->input('image');
                $destinationPath =  base_path() . '/public/images/products/';

                foreach ($image  as $item){
                    $product_image = new Product_image;
                    $img = str_replace('data:image/jpeg;base64,', '', $item['data']);
                    $data = base64_decode($img);
                    file_put_contents($destinationPath . $item['name'], $data);
                    $product_image->product_id = $product->product_id;
                    $product_image->name = '/images/products/' . $item['name'];
                    $product_image->location = $request->input('location');
                    $product_image->save();
                }
            } catch (Exception $e) {
               return response()->json(['error' => 'DB error.'], HttpResponse::HTTP_CONFLICT);
            }

            $status = 0;
            return response()->json(compact(['product', 'vault', 'product_image', 'status']));
        } 
        
    }

    /**=====================================
     *          Product Publish By Id
     *======================================*/
    public function dataPublishById(Request $request) {

        if ($request->isMethod('post')) {

            if (Product::where('product_id', $request->input('product_id'))->count() == 0)
                return response()->json(array('error' => 'Product not exists.'));

            $vault = new Vault;
            try {
            
                $vault = Vault::where('product_id', $request->input('product_id'))->first();

                $vault->published = $request->input('published');
                $vault->published_at = $request->input('published_at');
                $vault->date = $request->input('published_at');
                $vault->save();

            } catch (Exception $e) {
               return response()->json(['error' => 'DB error.'], HttpResponse::HTTP_CONFLICT);
            }

            $status = 0;
            return response()->json(compact(['status']));
        } 
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
