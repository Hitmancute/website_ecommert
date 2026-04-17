@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title">
                <h4>Data Category</h4>
                <a href="{{ route('data-category.index') }}" class="btn btn-outline-dark">Back</a>
            </div>
        </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="img-fluid">
                    </div>
                    <div class="col-6">
                        <h4 class="text-capitalize">Category : {{ $category->category_name }}</h4>
                        <div class="">
                            <small>Data Produt's</small>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
