@extends('layout')

@section('title', 'Search Results')

@section('extra-css')

@endsection

@section('content')

@component('components.breadcrumbs')
<a href="/">Home</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>Search</span>
@endcomponent

<div class="container">
    @if (session()->has('success_message'))
    <div class="alert alert-success">
        {{ session()->get('success_message') }}
    </div>
    @endif

    @if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<!-- end breadcrumbs -->

<div class="search-results-container container">
    <h1>Search Results</h1>
    <p class="search-results-count">{{ $products->total() }} result(s) for '{{ request()->input('query') }}'</p>
    @if ($products->total() > 0)
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Details</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <th><a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a></th>
                <th><img src="{{ asset('storage/'.$product->image) }}" alt="product" height="50"></th>
                <td>{{ Str::limit($product->details, 40) }}</td>
                <td>{{ Str::limit($product->description, 60) }}</td>
                <td>{{ $product->presentPrice() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="spacer"></div>
    {{ $products->appends(request()->input())->links() }}
    @else
    <div class="w-25"style="max-width: 25%;">
        <div class="alert alert-danger">No result...</div>
    </div>

    @endif
</div> <!-- end search-container -->
@endsection
@section('extra-js')
@endsection
