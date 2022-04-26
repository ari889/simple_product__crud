@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card radius-10 bg-gradient-deepblue">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 text-white">{{ $data['products'] }}</h5>
                    <div class="ms-auto">
                        <i class='bx bx-cart fs-3 text-white'></i>
                    </div>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">Total Products</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card radius-10 bg-gradient-orange">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 text-white">{{ $data['categories'] }}</h5>
                    <div class="ms-auto">
                        <i class='fas fa-list-ul fs-3 text-white'></i>
                    </div>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">Total Categories</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card radius-10 bg-gradient-ohhappiness">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 text-white">{{ $data['subcategories'] }}</h5>
                    <div class="ms-auto">
                        <i class='fas fa-list fs-3 text-white'></i>
                    </div>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">Total Sub categories</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end row-->
@endsection
