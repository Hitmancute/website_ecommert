@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title">Data Categories</h4>
            <a href="{{ route('data-category.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i>
                New Category
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse ($categories as $index => $category)
                    <div class="card col-4">
                        <div class="card-body">
                            <img src="{{ $category->image }}" alt="{{ $category->category_name }}" class="img-fluid"
                                style="height: 250px; width: 100%">
                            <div class="mt-3">
                                <h3 class="text-center mb-3">{{ $category->category_name }}</h3>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('data-category.destroy', $category->slug) }}"
                                        data-confirm-delete="true" class="btn btn-danger">
                                        <i class="ti ti-trash"></i>
                                        Delete
                                    </a>
                                    <a href="{{ route('data-category.show', $category->slug) }}" class="btn btn-info">
                                        <i class="ti ti-basket"></i>
                                        Detail
                                    </a>
                                    <a href="{{ route('data-category.edit', $category->slug) }}" class="btn btn-primary">
                                        <i class="ti ti-edit"></i>
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No Data</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
