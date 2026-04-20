<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="card-body d-flex justify-content-center align-items-center" id="image-preview"
                        style="height: 300px">
                        @if (isset($product) && $product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->product_name }}" class="img-fluid"
                                style="max-height: 100%; object-fit: contain">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>
                <div class="col-9">
                    <div class="form-group mb-2">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control"
                            value="{{ old('product_name', $product->product_name ?? '') }}">
                    </div>
                    <div class="form-group mb-2">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="" hidden>Choose Product Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="5"> {{ old('description', $product->description ?? '') }}</textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $product->is_acrive ?? 'false') ? 'checked' : '' }}>
                            <span class="form-check-label">Product Active?</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $("#image").on('change', function() {
                const file = this.files[0];
                if (!file) return;

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = "img-fluid rounded";
                img.style.maxHight = '100%';
                img.style.objectFit = 'contain';
                $("#image-preview").html(img);
            });
        });
    </script>
@endpush
