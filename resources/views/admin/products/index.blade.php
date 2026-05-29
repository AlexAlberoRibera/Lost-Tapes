@extends('layouts.products')
@section('title', 'Gestión de Productos')

@section('content')
<h1 class="text-3xl font-bold text-blue-800 mb-6">Gestión de Productos</h1>

@if (session('success'))
  <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">{{ session('success') }}</div>
@endif

@can('create', App\Models\Product::class)
<p class="mb-4">
  <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded">
    + Nuevo Producto
  </a>
</p>
@endcan

<div class="overflow-x-auto">
  <table class="w-full border-collapse border border-gray-300 text-sm">
    <thead class="bg-gray-200">
      <tr>
        <th class="border border-gray-300 p-2 text-left">SKU</th>
        <th class="border border-gray-300 p-2 text-left">Nombre</th>
        <th class="border border-gray-300 p-2 text-left hidden md:table-cell">Descripción</th>
        <th class="border border-gray-300 p-2 text-left hidden sm:table-cell">Precio</th>
        <th class="border border-gray-300 p-2 text-left hidden sm:table-cell">Stock</th>
        <th class="border border-gray-300 p-2 text-left">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $product)
        <tr class="hover:bg-gray-50">
          <td class="border border-gray-300 p-2">{{ $product->sku }}</td>
          <td class="border border-gray-300 p-2">
            <a href="{{ route('admin.products.show', $product->id) }}" class="text-blue-700 hover:underline">
              {{ $product->name }}
            </a>
          </td>
          <td class="border border-gray-300 p-2 hidden md:table-cell max-w-xs truncate">
            {{ $product->description }}
          </td>
          <td class="border border-gray-300 p-2 hidden sm:table-cell">€{{ $product->price }}</td>
          <td class="border border-gray-300 p-2 hidden sm:table-cell">{{ $product->stock }}</td>
          <td class="border border-gray-300 p-2">
            <div class="flex gap-2">
              @can('update', $product)
                <a href="{{ route('admin.products.edit', $product->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                  Editar
                </a>
              @endcan
              @can('delete', $product)
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                      onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                    Borrar
                  </button>
                </form>
              @endcan
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
