@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Product</div>
                    <div class="card-body">
                        <div class="card card-body bg-light text-center" >
                            <form action="{{ route('product.update', $product) }}" method="post" >
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="product_name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="product_name" type="text" class="form-control{{ $errors->has('product_name') ? ' is-invalid' : '' }}" name="product_name" value="{{ old('product_name') ?? $product->product_name }}" required autofocus>

                                        @if ($errors->has('product_name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Quantity in Stock') }}</label>

                                    <div class="col-md-6">
                                        <input id="quantity" type="number" min="0" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity_in_stock" value="{{ old('quantity_in_stock') ?? $product->quantity }}" required autofocus>

                                        @if ($errors->has('quantity'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="price_per_item" class="col-md-4 col-form-label text-md-right">{{ __('Price Per Item') }}</label>

                                    <div class="col-md-6">
                                        <input id="price_per_item" type="number" min="0" class="form-control{{ $errors->has('price_per_item') ? ' is-invalid' : '' }}" name="price_per_item" value="{{ old('price_per_item') ?? $product->price_per_item }}" required autofocus>

                                        @if ($errors->has('price_per_item'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price_per_item') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
