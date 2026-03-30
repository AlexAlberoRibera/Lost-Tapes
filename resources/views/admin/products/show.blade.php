@extends('layouts.products')

@section('title', $product->name)

@section('content')
<h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
<p><strong>Descripción:</strong> {{ $product->description }}</p>
<p><strong>Categoría:</strong> {{ $product->category }}</p>
<p><strong>Precio:</strong> €{{ $product->price }}</p>
<p><strong>Stock:</strong> {{ $product->stock }}</p>
<img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="mt-4 w-64 h-auto">
<a href="{{ route('admin.products.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-3 py-2 rounded">Volver</a>
@endsection