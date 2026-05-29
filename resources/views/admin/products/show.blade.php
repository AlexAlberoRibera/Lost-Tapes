@extends('layouts.products')
@section('title', $product->name)

@section('content')
<div class="max-w-xl">
  <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

  @if($product->image)
    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"
         class="mb-4 w-48 h-auto rounded shadow">
  @endif

  <dl class="space-y-2 text-sm">
    <div><dt class="font-bold inline">SKU:</dt> <dd class="inline">{{ $product->sku }}</dd></div>
    <div><dt class="font-bold inline">Descripción:</dt> <dd class="inline">{{ $product->description ?? '—' }}</dd></div>
    <div><dt class="font-bold inline">Categoría:</dt> <dd class="inline">{{ $product->category }}</dd></div>
    <div><dt class="font-bold inline">Precio:</dt> <dd class="inline">€{{ $product->price }}</dd></div>
    <div><dt class="font-bold inline">Stock:</dt> <dd class="inline">{{ $product->stock }}</dd></div>
  </dl>

  <div class="mt-6 flex gap-3">
    @can('update', $product)
      <a href="{{ route('admin.products.edit', $product->id) }}"
         class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">
        Editar
      </a>
    @endcan
    <a href="{{ route('admin.products.index') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm">
      Volver
    </a>
  </div>
</div>
@endsection
