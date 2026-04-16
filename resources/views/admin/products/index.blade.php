@extends('layouts.products')
@section('title', "Lost Tapes")

@section('content')
<h1 class="text-3xl font-bold text-blue-800 mb-6">Guia de Productos</h1>

@if (session('success'))
  <div class="bg-green-100 text-green-700 p-2 mb-4">{{ session('success') }}</div>
@endif

@can('create', Product::class)
<p class="mb-4">
  <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">Nuevo Producto</a>
</p>
@endcan

<table class="w-full border-collapse border border-gray-300">
  <thead class="bg-gray-200">
  <tr>
    <th class="border border-gray-300 p-2">{{ __('Nombre') }}</th>
    <th class="border border-gray-300 p-2">{{ __('Descripcion') }}</th>
    <th class="border border-gray-300 p-2">{{ __('Acciones')}} </th>
  </tr>
  </thead>
  <tbody>
  @foreach($products as  $product)
    <tr class="hover:bg-gray-100">
      <td class="border border-gray-300 p-2">
        <a href="{{ route('admin.products.show',  $product->id) }}" class="text-blue-700 hover:underline">{{ $product->name }}</a>
      </td>
      <td class="border border-gray-300 p-2">{{ $product->description }}</td>
      <td class="border border-gray-300 p-2 flex space-x-2">
        @can('update', $product)
            <a href="{{ route('admin.products.edit', $product->id) }}"
              class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 flex items-center space-x-1">
                <span>✏️</span>
            </a>
        @endcan
        @can('delete',$product)
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
              onsubmit="return confirm('Segur que vols eliminar?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 flex items-center space-x-1">
                    <span>🗑️</span>
                </button>
            </form>
        @endcan
    </td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection