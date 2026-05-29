@extends('layouts.products')
@section('title', 'Añadir producto')

@section('content')
<h1 class="text-2xl font-bold mb-4">Añadir nuevo producto</h1>

@if ($errors->any())
  <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
    <ul class="list-disc ml-5">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" class="space-y-4 max-w-lg">
  @csrf

  <div>
    <label for="sku" class="block font-bold mb-1">SKU:</label>
    <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="border p-2 w-full rounded" required>
  </div>

  <div>
    <label for="name" class="block font-bold mb-1">Nombre:</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}" class="border p-2 w-full rounded" required>
  </div>

  <div>
    <label for="description" class="block font-bold mb-1">Descripción:</label>
    <textarea name="description" id="description" rows="3" class="border p-2 w-full rounded">{{ old('description') }}</textarea>
  </div>

  <div>
    <label for="price" class="block font-bold mb-1">Precio (€):</label>
    <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price') }}" class="border p-2 w-full rounded" required>
  </div>

  <div>
    <label for="stock" class="block font-bold mb-1">Stock:</label>
    <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', 0) }}" class="border p-2 w-full rounded" required>
  </div>

  <div>
    <label for="image" class="block font-bold mb-1">Imagen (nombre de archivo):</label>
    <input type="text" name="image" id="image" value="{{ old('image') }}" class="border p-2 w-full rounded" placeholder="ej: harakiri.jpg">
  </div>

  <div>
    <label for="category" class="block font-bold mb-1">Categoría:</label>
    <input type="text" name="category" id="category" value="{{ old('category', 'pelicula') }}" class="border p-2 w-full rounded" required>
  </div>

  <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
    Añadir producto
  </button>
</form>
@endsection
