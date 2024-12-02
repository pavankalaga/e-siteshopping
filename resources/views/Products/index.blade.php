@extends('layouts.app')
<style>
    
    .table-hover tbody tr:hover {
        background-color: #f9f9f9; 
    }

    .table thead th {
        background-color: #007bff; 
        color: #fff; 
        font-size: 1rem;
        font-weight: bold;
    }

    .table-bordered {
        border: 1px solid #dee2e6; 
    }

    .table-primary {
        background-color: #007bff; 
        color: white;
    }

    .btn-primary {
        background-color: #0056b3; 
        border: none;
    }

    .btn-primary:hover {
        background-color: #003f7f; 
    }

    
    .dataTables_processing {
        background-color: rgba(0, 123, 255, 0.1); 
        font-size: 1.2rem;
        font-weight: bold;
        color: #0056b3;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @media (max-width: 768px) {
        .btn-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .btn-container a {
            margin-bottom: 0.5rem; 
            width: 100%; 
        }

        .table {
            font-size: 0.9rem; 
        }
    }

    @media (max-width: 576px) {
        .table {
            font-size: 0.8rem; 
        }

        .table img {
            width: 40px; 
            height: 40px; 
        }
    }
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10">
            <h3>Products</h3>
        </div>
        
    <div class="col-lg-2 col-md-3 col-sm-4 btn-container d-flex justify-content-end mb-2">
        <a href="{{route('card.views')}}" class="btn btn-outline-primary btn-sm d-flex align-items-center me-2">
            <i class="fas fa-th-large" style="font-size: 18px; margin-right: 4px; color: #0078d7;"></i>
            View
        </a>
        <a href="{{route('cart.index')}}" class="btn btn-outline-primary btn-sm d-flex align-items-center">
            <i class="fas fa-shopping-cart" style="font-size: 18px; margin-right: 4px; color: #0078d7;"></i>
            MyCart
        </a>
    </div>


    </div>
    <br>
    <table id="products-table" class="table table-hover table-bordered text-center align-middle shadow-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('product.index') }}", 
        columns: [
            {
                data: null, 
                name: 'serial',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + 1; 
                }
            },
            {
                data: 'image',
                name: 'image',
                orderable: false,
                searchable: false,
                render: function(data) {
                    const defaultImage = "{{ asset('images/shopping-cart.jpg') }}"; 
                    const imagePath = data ? data : defaultImage; 
                    return `<img src="${imagePath}" alt="Product Image" style="width: 50px; height: 50px; border-radius: 5px;">`;
                }
            },
            { data: 'name', name: 'name' }, 
            { data: 'description', name: 'description' }, 
            { data: 'price', name: 'price' }, 
            { data: 'action', name: 'action', orderable: false, searchable: false }, 
        ],
        pageLength: 10,
        responsive: true, 
    });
});
</script>
@endpush

