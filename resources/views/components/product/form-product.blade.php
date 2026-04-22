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
        @if ($product)
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
                            <input type="checkbox" name="is_active" class="form-check-input" value="1"
                                {{ old('is_active', $product->is_active ?? 'false') ? 'checked' : '' }}>
                            <span class="form-check-label">Set Product Active?</span>
                        </label>
                    </div>

                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <h5>Product Variant</h5>
                    <input type="hidden" name="variant_id" id="variant_id">
                    <div class="row gap-2 mb-2">
                        <div class="col-4">
                            <input type="text" name="variant_name" id="variant_name" class="form-control"
                                placeholder="Variant Name">
                        </div>
                        <div class="col-3">
                            <input type="number" name="price" id="price" class="form-control" placeholder="Rp.">
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <label for="" class="form-check">
                                <input type="checkbox" id="variant_is_active" id="variant_is_active"
                                    class="form-check-input">
                                <span class="form-check-label">Set Active?</span>
                            </label>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-primary w-100" id="add_variant">Add</button>
                        </div>
                    </div>

                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Variant</th>
                                <th style="width: 20%">Price</th>
                                <th style="width: 15%">Status</th>
                                <th style="width: 15%">Option</th>
                            </tr>
                        </thead>
                        <tbody id="table-variant"></tbody>
                    </table>

                    <input type="hidden" name="variants" id="variants" value="{{ old('variants') }}">
                    <input type="hidden" id="initial_variants" value="@json(old('variants') ? json_decode(old('variants')) : $product->variants ?? [])">
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
                img.style.maxHeight = '100%';
                img.style.objectFit = 'contain';
                $("#image-preview").html(img);
            });

            let variants = [];
            let editingIndex = null;

            const initialvariants = $("#initial_variants").val();
            if (initialvariants) {
                try {
                    variants = JSON.parse(initialvariants).map(v => ({
                        id: v.id ?? null,
                        variant_name: v.variant_name,
                        price: v.price,
                        is_active: Number(v.is_active)
                    }));
                } catch (e) {
                    console.error("Invalid JSON", e);
                }
            }

            renderVariant();

            $("#add_variant").on('click', function() {
                const name = $("#variant_name").val().trim();
                const price = $("#price").val();
                const active = $("#variant_is_active").is(":checked") ? 1 : 0;

                if (!name || !price) {
                    alert('Variant name and price must be filled!');
                    return;
                }

                if (editingIndex !== null) {
                    variants[editingIndex] = {
                        ...variants[editingIndex],
                        variant_name: name,
                        price: price,
                        is_active: active
                    };
                } else {
                    const existingVariant = variants.find(v => v.variant_name === name);
                    if(existingVariant){
                        existingVariant.price = price;
                        existingVariant.is_active = active;
                    }else{
                        variants.push({
                            id: null,
                            variant_name: name,
                            price: price,
                            is_active: active
                        });

                    }
                }

                renderVariant();
                resetVariantForm();
            });

            function renderVariant() {
                let html = "";

                if (variants.length === 0) {
                    html += `
                <tr>
                    <td colspan="5" class="text-center">No Data</td>
                </tr>
                `;
                } else {
                    variants.forEach((v, i) => {
                        html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${v.variant_name}</td>
                        <td>Rp. ${Number(v.price).toLocaleString()}</td>
                        <td>${v.is_active ? 'Active' : 'Inactive'}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-warning" onclick='editVariant(${i})'>
                                <i class="ti ti-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick='deleteVariant(${i})'>
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    });
                }

                $("#table-variant").html(html);
                $("#variants").val(JSON.stringify(variants));
            }

            function resetVariantForm() {
                editingIndex = null;
                $("#variant_id").val('');
                $("#variant_name").val('');
                $("#price").val('');
                $("#variant_is_active").prop('checked', false);
                $("#variant_name").focus();
                $("#add_variant").text('Add');
            }

            window.editVariant = function(index) {
                const v = variants[index];
                editingIndex = index;

                $("#variant_id").val(v.id ?? '');
                $("#variant_name").val(v.variant_name);
                $("#price").val(v.price);
                $("#variant_is_active").prop('checked', v.is_active === 1);
                $("#add_variant").text('Update');
            }

            window.deleteVariant = function(index) {
                variants.splice(index, 1);
                renderVariant();
                resetVariantForm();
            }
        });
    </script>
@endpush
