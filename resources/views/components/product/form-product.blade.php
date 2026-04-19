<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <li class="mb-0">
                @foreach ($errors->all() as $error)
                    <ul>{{ $error }}</ul>
                @endforeach
            </li>
        </div>
    @endif
    <form action="{{ $action }}" class="card" method="POST" enctype="multipart/form-data">
        @csrf
        @if (!empty($product))
            @method('PUT')
        @endif
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title">Form {{ $product ? 'Edit' : 'Create' }} Product</h4>
            <div>
                <a href="{{ route('data-product.index') }}" class="btn btn-outline-dark"> Back</a>
                <button type="submit" class="btn btn-dark">
                    <i class="ti ti-device-floppy"></i>
                    Save
                </button>
            </div>
        </div>
    </form>
</div>
