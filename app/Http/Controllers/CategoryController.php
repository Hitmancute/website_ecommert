<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        confirmDelete('Data will be deleted permanent!');
        $categories = Category::select('id', 'category_name', 'slug', 'image')->get()->map(function ($q) {
            $q->image = asset('storage/category/' . $q->image);
            return $q;
        });
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $slug = Str::slug($request->category_name);
        $image = $request->file('image');
        $fileName = $slug . "." . $image->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('category', $image, $fileName);
        Category::create([
            "category_name"     => $request->category_name,
            "slug"              => $slug,
            "image"             => $fileName,
        ]);
        toast()->success('Category created successfully!!');
        return Redirect()->route('data-category.index');
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $category->image = asset('storage/category/' . $category->image);
        return view('category.edit', compact('category'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $category->image = asset('storage/category/' . $category->image);
        return view('category.show', compact('category'));
    }

    public function update(CategoryUpdateRequest $request)
    {
        $id = $request->id;
        $dataCategory = Category::where('id', $id)->first();
        $categoryName = $request->category_name;
        $slug         = Str::slug($request->category_name);

        $dataCategory->category_name = $categoryName;
        $dataCategory->slug = $slug;
        $dataCategory->save();

        if ($request->hasFile('image')) {
            // delete file
            Storage::disk('public')->delete('category/' . $dataCategory->image);
            $image = $request->file('image');
            $fileName = $slug . '.' . $image->getClientOriginalExtension();
            // save file
            Storage::disk('public')->putFileAs('category', $image, $fileName);
            $dataCategory->image = $fileName;
            $dataCategory->save();
        }
        toast()->success('Category Update successfully!!');
        return Redirect()->route('data-category.index');
    }

    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->first();
        Storage::disk('public')->delete('caregory/' . $category->image);
        $category->delete();
        toast()->success('Category delete successfully!!');
        return Redirect()->route('data-category.index');
    }
}
