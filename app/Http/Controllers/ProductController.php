<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        confirmDelete('Delete this product?', 'Data will be deleted permanent!!');
        $products = Product::with('category:id,category_name')->select('id', 'product_name', 'slug', 'is_active', 'image', 'category_id', 'description')->get()->map(function($q){
            $q->image = asset('storage/product/'. $q->image);
            return $q;
        });
        return view('product.index',compact('products'));
    }

    public function create(){
        return view('product.create');
    }

    public function store(ProductStoreRequest $request){
        $productName = $request->product_name;
        $categoryId  = $request->category_id;
        $slug = Str::slug($request->product_name);
        $image = $request->file('image');
        $fileName = $slug.'.'.$image->getClientOriginalExtension();
        $description = $request->description;
        $is_active = $request->is_activr ?? false;
        $variants = json_decode($request->variants, true);

        $product = Product::create([
            'product_name'  => $productName,
            'category_id'  => $categoryId,
            'slug'  => $slug,
            'image'  => $fileName,
            'description'  => $description,
            'is_active'  => $is_active,
        ]);

        $product->variants()->createMany($variants);

        Storage::disk('public')->putFileAs('product',$image, $fileName);
        toast()->success('Product created succesfully');
        return redirect()->route('data-product.index');
    }
}
