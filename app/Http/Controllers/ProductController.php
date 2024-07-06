<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'product_description' => 'required|string',
            'product_images' => 'required',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        $imagePaths = [];
        if($request->hasfile('product_images'))
        {
            foreach($request->file('product_images') as $image)
            {
                $name = time().rand(1,100).'.'.$image->extension();
                $image->move(public_path('images'), $name);  
                $imagePaths[] = $name;  
            }
        }
    
        $data['product_images'] = $imagePaths;
    
        Product::create($data);
    
        return redirect()->route('products.index');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // return view('products.edit', compact('product'));
        return view('products.create', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
  
    
     public function update(Request $request, $id)
     {
         $product = Product::findOrFail($id);
         $product->product_name = $request->input('product_name');
         $product->product_price = $request->input('product_price');
         $product->product_description = $request->input('product_description');
         
       
        
         if ($request->has('delete_images')) {
             foreach ($request->delete_images as $image) {
                 
                 $del_img=Storage::delete('public/images/'.$image);
                 //dd($del_img);
                
                $productImages = $product->product_images; 
                $productImages = array_diff($productImages, [$image]); 
                $product->product_images = $productImages; 
             }
         }
 
         // Handle new image upload
         if ($request->hasFile('product_images')) {
             foreach ($request->file('product_images') as $file) {
           
                 $filename = $file->getClientOriginalName();
                 $file->storeAs('public/images', $filename);
                 
               
                 $product->product_images()->create(['image_name' => $filename]);
             }
         }
 
         $product->save();
 
         return redirect()->route('products.index')->with('success', 'Product updated successfully');
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
    
}
