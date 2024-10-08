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



    public function getproducts(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $page = $request->query('page', 1);
        $orderBy = $request->query('order_by', 'name');
        $orderDirection = $request->query('order_direction', 'asc');
        

        $validColumns = ['id', 'name', 'price'];
        if (!in_array($orderBy, $validColumns)) {
            $orderBy = 'id';
        }

        $orderDirection = strtolower($orderDirection) === 'desc' ? 'desc' : 'asc';

        $productsQuery = Product::with('images')->orderBy($orderBy, $orderDirection);
        if($request->query('top')){
            $productsQuery = $productsQuery->where('top','Y');
        }

        if($request->query('feature')){
            $productsQuery = $productsQuery->where('feat','Y');
        }

        if($request->query('category')){
            $productsQuery = $productsQuery->where('category_id', $request->query('category'));
        }
        if($request->query('subcategory')){
            $productsQuery = $productsQuery->where('subcategory_id', $request->query('subcategory'));
        }

        $products = $productsQuery->paginate($perPage, ['*'], 'page', $page);

        return response()->json($products);
    }


    public function getitem($pid){
        $item = Product::with('images')->find($pid);
        if ($item) {
            return response()->json($item);
        }
        return response()->json(['message'=>"Item not found"], 404);
    }

    public function search_item(Request $request)
    {
        $search_text = $request->input('term');

        if ($search_text) {
            $products = Product::where('name', 'like', "%{$search_text}%")
                ->orWhere('price', 'like', "%{$search_text}%")
                ->orWhere('code', 'like', "%{$search_text}%")
                ->orWhere('mfg_name', 'like', "%{$search_text}%")
                ->with('images')
                ->take(50)
                ->get();
    
            return response()->json($products, 200);
        }else{
            return response()->json(null, 400);
        }
    }
}
