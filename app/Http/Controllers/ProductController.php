<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProduct;
use Illuminate\Support\Facades\Storage;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::simplepaginate(4);
        return view('admin.products.index')->with('products',$products);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create')->with('categories',$categories );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //dd(session()->get('cart'));
        $categories = Category::all();
        $products = Product::all();
        return view('products.all')->with([
            'categories'=>$categories,
            'products'=>$products, 
        ]);
    }
    public function single(Product $product){
        return view('products.single')->with('product',$product);
    }

    public function addToCart(Product $product, Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $qty = $request->qty ? $request->qty : 1;
        $cart = new Cart($oldCart);
        $cart->addProduct($product, $qty);
        Session::put('cart', $cart);
        return back()->with('message', "Product $product->title has been successfully added to Cart");
    }

    public function cart(){
        //dd(session()->get('cart'));
        if(!Session()->has('cart')){
            return view('products.cart');
        }else{
            $cart = Session::get('cart');
            return view('products.cart')->with('cart',$cart);
        }
        
    }
    public function removeProduct(Product $product){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeProduct($product);
        Session::put('cart' , $cart);
        return back()->with('message', "Product $product->title has been successfully Removed From Cart");
    } 

    public function updateProduct(Product $product , Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->updateProduct($product , $request->qty);
        Session::put('cart' , $cart);
        return back()->with('message', "Product $product->title has been successfully Updated in Your Cart");
    } 

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,StoreProduct $product)
    {
        $extension = ".".$request->thumbnail->getClientOriginalExtension();
        $name = basename($request->thumbnail->getClientOriginalName(),$extension).time();
        $name = $name.$extension;
        $path = $request->thumbnail->storeAs('images',$name,'public');
        $product=Product::create([
                    'title'=>$request->title,
                    'slug'=>$request->slug,
                    'description'=>$request->description,
                    'thumbnail'=>$name,
                    'status'=>$request->status,
                    'options'=>isset($request->extras) ? json_encode($request->extras) : null,
                    'featured'=>($request->featured)? $request->featured:0,
                    'price'=>$request->price,
                    'discount'=>($request->discount)? $request->discount : 0,
                    'discount_price'=>($request->discount_price)? $request->discount_price :0,
                ]);
        if($product){
            $product->categories()->attach($request->category_id);
            return back()->with('message','Product Successfully Added');
        }else{
            return back()->with('message','Error Inserting Record');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories=Category::all();
        return view('admin.products.create')->with([
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, Product $product)
    {
        if($request->has('thumbnail')){
            $extension = ".".$request->thumbnail->getClientOriginalExtension();
            $name = basename($request->thumbnail->getClientOriginalName(),$extension).time();
            $name = $name.$extension;
            $path = $request->thumbnail->storeAs('images',$name);
            $product->thumbnail = $name;
        }
        $product->title = $request->title;
        //$product->slug = $request->slug;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->featured = ($request->featured)? $request->featured: 0 ;
        $product->price = $request->price;
        $product->discount = ($request->discount)? $request->discount: 0 ;
        $product->discount_price = ($request->discount_price)? $request->discount_price: 0 ;

        $product->categories()->detach();
        if($product->save()){
            $product->categories()->attach($request->category_id);
            return back()->with('message','Product Successfully Updated!');
        }else{
            return back()->with('message','Error Updating Product');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->categories()->detach() && $product->ForceDelete()){
            Storage::delete($product->thumbnail);
            return back()->with('message','Product Deleted Successfully!');
        }else{
            return back()->with('message','Error Deleting Product!');
        }
    }

    public function remove(Product $product)
    {
        if($product->delete()){
            return back()->with('message','Product Trashed Successfully!');
        }else{
            return back()->with('message','Error Trashing Product!');
        }
    }

    public function recoverProduct($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        if($product->restore()){
            return back()->with('message','Product restored Successfully!');
        }else{
            return back()->with('message','Error Restoring Product!');
        }   
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(3);
        return view('admin.products.index')->with('products',$products);
    }
}
