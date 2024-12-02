@extends('layouts.app')
@section('content')

@if (session('error'))
<div class=" alert alert-danger" >
    {{session('error')}}
</div>
@endif
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-50">
        <div class="card-header bg-primary text-white">Fill the Form</div>
        <div class="card-body">
            <form action="{{ route('mobile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-3">
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        {{$message}}
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="">Brand</label>
                    <select name="brand" class="form-control">
                        <option value="select">Select Brand</option>
                        @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="" class="form-label">Price</label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                    @error('price')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="">Features</label>
                    <div class="d-flex flex-wrap">
                        <div class="form-check me-3">
                            <input type="checkbox" class="form-check-input" value="battery" name="features[]">
                            <label for="" class="form-check-label">Battery</label>
                        </div>
                        <div class="form-check me-3">
                            <input type="checkbox" class="form-check-input" value="camera" name="features[]">
                            <label for="" class="form-check-label">Camera</label>
                        </div>
                        <div class="form-check me-3">
                            <input type="checkbox" class="form-check-input" value="storage" name="features[]" checked>
                            <label for="" class="form-check-label">Storage</label>
                        </div>
                    </div>
                    @error('features')
                    <span class="invalid-feedback" role="alert">
                             {{$message}}
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                   <label for="">Image</label>
                   <input type="file" name="image" class="form-control" value="{{old('image')}}" placeholder="upload image">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection