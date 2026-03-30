<div>
    <form action="{{ $action }}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($category)
            @method('PUT')
        @endif
        <div class="form-group my-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control"
                value="{{ $category->name ?? old('category_name') }}">
            @error('category_name')
                <small class="text-danger">{{ $massage }}</small>
            @enderror
        </div>
        <div class="form-group my-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
