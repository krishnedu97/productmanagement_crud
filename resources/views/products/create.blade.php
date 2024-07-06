<!-- resources/views/products/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($product) ? 'Edit Product' : 'Add Product' }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h1>
        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ isset($product) ? $product->product_name : '' }}" required>
            </div>
            <div class="form-group">
                <label for="product_price">Product Price</label>
                <input type="text" class="form-control" id="product_price" name="product_price" value="{{ isset($product) ? $product->product_price : '' }}" required>
            </div>
            <div class="form-group">
                <label for="product_description">Product Description</label>
                <textarea class="form-control" id="product_description" name="product_description" rows="4" required>{{ isset($product) ? $product->product_description : '' }}</textarea>
            </div>
            @if(isset($product) && is_array($product->product_images) && count($product->product_images) > 0)
                <div class="form-group">
                    <label for="product_images">Current Images</label>
                    <div class="mb-2">
                        @foreach($product->product_images as $image)
                            <div class="mb-2">
                                <img src="{{ asset('images/'.$image) }}" width="100" height="100" class="img-thumbnail mr-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="image_{{ $loop->index }}" name="delete_images[]" value="{{ $image }}">
                                    <label class="form-check-label" for="image_{{ $loop->index }}">Delete</label>
                                    <input type="hidden" name="existing_images[]" value="{{ $image }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="form-group">
                <label for="product_images">Upload New Images (optional)</label>
                <input type="file" class="form-control-file" id="product_images" name="product_images[]" multiple>
            </div>
            <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Submit' }}</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary ml-2">Cancel</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
