@extends('layouts.products')
@section('title', 'Afegir nou equip')

@section('content')
<h1 class="text-2xl font-bold mb-4">Añadir nuevo producto</h1>

@if ($errors->any())
  <div class="bg-red-100 text-red-700 p-2 mb-4">
    <ul>
      @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('products.store') }}" method="POST" class="space-y-4">
  @csrf
  <div>
    <label for="name" class="block font-bold">Nombre:</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}" class="border p-2 w-full">
  </div>
  <div>
    <label for="description" class="block font-bold">Description:</label>
    <input type="text" name="description" id="description" value="{{ old('description') }}" class="border p-2 w-full">
  </div>
  <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Añadir</button>
</form>
@endsection