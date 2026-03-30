<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::select('id', 'category_name', 'slug', 'image')->get()->map(function ($q) {
            $q->image = asset('storage/category/' . $q->image);
            return $q;
        });
        return view('category.index', compact('categories'));
    }

    public function create(){
        return view('category.create');
    }
}
