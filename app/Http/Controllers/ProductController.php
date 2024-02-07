<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }


    // api
    public function search_item(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);
        $search_text = $request->input('search');

        $products = Product::where('name', 'like', "%{$search_text}%")
                        ->orWhere('retail_price', 'like', "%{$search_text}%")
                        ->orWhere('code', 'like', "%{$search_text}%")
                        ->orWhere('mfg_name', 'like', "%{$search_text}%")
                        ->get();
    
        return response()->json($products);
    }
}
