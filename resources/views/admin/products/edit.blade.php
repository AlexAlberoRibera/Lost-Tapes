@extends('layouts.products')
@section('title', __("Modificar Producto"))

@section('content')
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-bold">SKU:</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-bold">Nombre:</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-bold">Descripción:</label>
            <input type="text" name="description" value="{{ old('description', $product->description) }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-bold">Precio:</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-bold">Stock:</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-bold">Imagen (nombre archivo):</label>
            <input type="text" name="image" value="{{ old('image', $product->image) }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block font-bold">Categoría:</label>
            <select name="category" class="border p-2 w-full">
                <option value="pelicula" {{ old('category', $product->category) == 'pelicula' ? 'selected' : '' }}>
                    Película
                </option>
            </select>
        </div>

        <button type="submit"
        class="mt-4 inline-block bg-blue-600 text-white px-3 py-2 rounded">
    Actualitzar
</button>
    </form>
@endsection