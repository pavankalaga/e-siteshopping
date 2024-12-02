@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        @foreach ($products as $item)
        <div class="col-lg-4 col-md-6 mb-4"> 
            <div class="card h-100"> 
                <img src="{{ asset('images/shopping-cart.jpg') }}" class="card-img-top" alt="{{ $item->name }}">
                <div class="card-body d-flex flex-column"> 
                    <h5 class="card-title">{{ $item->name }}/ ${{ $item->price }}</h5>
                    <p class="card-text mb-3">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempora labore eos recusandae consequuntur error facere and debitis.</p>
                    <div class="mt-auto"> 
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="hidden" name="name" value="{{ $item->name }}">
                            <input type="hidden" name="price" value="{{ $item->price }}">
                            <button type="submit" class="btn btn-primary w-100"> 
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
