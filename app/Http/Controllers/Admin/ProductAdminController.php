<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductAdminController extends Controller {
    public function __construct(private ProductService $servei) {}

    // GET /products
    public function index() {
        return view('admin.products.index', ['products' => $this->servei->llistar()]);
    }

    // GET /products/create
    public function create() {
        $products = Product::all();
        return view('admin.products.create',compact('products'));
    }
    // POST /products
    public function store(StoreProductRequest $request) {
        $this->servei->guardar($request->validated());
        return redirect()->route('admin.products.index');
    }

    // GET /products/{id}
    public function show(Product $product) {
        return view('admin.products.show', compact('product'));
    }

    // GET /products/{id}/edit
    public function edit(Product $product) {
        return view('admin.products.edit', compact('product'));
    }

    // PUT /products/{id}/edit
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();    
        $product->update($data);    
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    // DELETE /products/{id}
    public function destroy($id) {
        $this->servei->eliminar($id);
        return redirect()->route('admin.products.index');
    }
}