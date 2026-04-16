@extends('layouts.products')

@section('title', "Importar Productos")

@section('content')

<h1 class="text-3xl font-bold text-blue-800 mb-6">
    Importar Productos
</h1>

{{-- MENSAJE DE ÉXITO --}}
@if (session('success'))
    <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

{{-- ERRORES DE VALIDACIÓN --}}
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- FORMULARIO --}}
<div class="bg-white shadow p-6 rounded-lg max-w-lg">

    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block font-bold mb-2">
                Archivo Excel
            </label>

            <input type="file"
                   name="excel_file"
                   class="border p-2 w-full rounded"
                   required>
        </div>

        <br><button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Importar productos
        </button>
    </form>

</div>

@endsection