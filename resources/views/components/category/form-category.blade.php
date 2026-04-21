<div>
    <form action="{{ $action }}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($category)
            @method('PUT')
            <input type="hidden" name="id" value="{{ $category->id }}"> 
            <div>
                <img src="{{ $category->image }}" alt="{{ $category->category_name }}" class="img-fluid">
            </div>
        @endif
        <div class="form-group my-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control"
            value="{{ old('category_name', $category->category_name ?? '') }}">
            @error('category_name')
                <small class="text-danger">{{ $message }}</small>
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
