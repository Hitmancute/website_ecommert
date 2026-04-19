@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Data Produt</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produt</th>
                        <th>Category</th>
                        <th>Variants</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $index => $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category->category_name }}</td>
                            <td>{{ $product->variants->count() }}</td>
                            <td>
                                <span
                                    class="badge rounded-all {{ $product->is_active ? 'text-primary' : 'text-bg-warning' }}">
                                    {{ $product->is_active ? 'Active' : 'No Active' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
