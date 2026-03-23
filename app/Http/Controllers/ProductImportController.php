<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{
    public function showForm()
    {
        return view('products.import'); // crea la vista más adelante
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ProductsImport, $request->file('excel_file'));

        return redirect()->back()->with('success', 'Importación completada');
    }
}