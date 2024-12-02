@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-3">
        <div class="row">
            <div class="col-md-5">
                <div class="text-center">
                    <img src="{{ asset('images/shopping-cart.jpg') }}" alt="{{ $product->name ?? 'N/A' }}" class="img-fluid rounded" style="max-height: 400px;">
                </div>
            </div>

            <div class="col-md-7">
                <h2 class="mb-3">{{ $product->name ?? 'N/A' }}</h2>
                <h4 class="text-muted mb-4">Price: <span class="text-success">${{ number_format($product->price, 2) }}</span></h4>
                
                <p class="text-secondary mb-4">{{ $product->description }}</p>

                

                <div>
                    <a href="{{ route('product.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                   
                    <form action="{{ route('cart.add') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $product->id }}">
    <input type="hidden" name="name" value="{{ $product->name }}">
    <input type="hidden" name="price" value="{{ $product->price }}">
    <button type="submit" class="btn btn-primary mt-2"> <i class="fas fa-shopping-cart"></i> Add to Cart</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
