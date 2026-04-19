<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}
