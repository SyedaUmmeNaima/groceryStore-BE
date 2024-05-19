<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required',
            'product_amount' => 'required',
            'product_quantity' => 'required',
        ]);

        $product = Product::create($data);

        if ($request->hasFile('product_image')) {
            $imageName = time() . Str::random() . '.' . $request->file('product_image')->extension();
            $request->file('product_image')->storeAs('public/products', $imageName);
            $product->product_image = $imageName;
            $product->save();
        }

        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }

        $data = $request->validate([
            'product_name' => 'required',
            'product_amount' => 'required',
            'product_quantity' => 'required',
        ]);

        $product->update($data);

        if ($request->hasFile('product_image')) {
            $imageName = time() . Str::random() . '.' . $request->file('product_image')->extension();
            $request->file('product_image')->storeAs('public/products', $imageName);
            $product->product_image = $imageName;
            $product->save();
        }

        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        $product->delete();
        return response()->json(null, 204);
    }

    public function index()
    {
        $products = Product::all()->map(function ($product) {
            $product->product_image = url('storage/products/' . $product->product_image);
            return $product;
        });

        return response()->json($products, 200);
    }
}
