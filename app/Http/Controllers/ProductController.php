<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $type_menu = 'product';
        return view('pages.products.index', compact('products', 'type_menu'));
    }

    public function create()
    {
        $type_menu = 'product';
        return view('pages.products.create', compact('type_menu'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        \App\Models\Product::create($data);
        return redirect()->route('product.index')->with('success', 'product berhasil dibuat');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $type_menu = 'product';
        return view('pages.products.edit', compact('product', 'type_menu'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = \App\Models\Product::findOrFail($id);
        $product->update($data);
        return redirect()->route('product.index')->with('success', 'product berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'product berhasil dihapus');
    }
}
