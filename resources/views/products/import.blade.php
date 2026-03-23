@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="excel_file" required>
    <button type="submit">Importar productos</button>
</form>