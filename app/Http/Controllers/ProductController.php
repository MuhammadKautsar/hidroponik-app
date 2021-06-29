<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    function post(Request $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->active = $request->active;
        $product->description = $request->description;

        $product->save();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $product
            ]
        );
    }

    function get()
    {
        $data = Product::all();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $data
            ]
        );
    }

    function getById($id)
    {
        $data = Product::where('id', $id)->get();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $data
            ]
        );
    }

    function put($id, Request $request)
    {
        $product = Product::where('id', $id)->first();
        if($product){
            $product->name = $request->name ? $request->name : $product->name;
            $product->price = $request->price ? $request->price : $product->price;
            $product->quantity = $request->quantity ? $request->quantity :$product->quantity;
            $product->active = $request->active ? $request->active :$product->active;
            $product->description = $request->description ? $request->description :$product->description;

            $product->save();
            return response()->json(
                [
                    "message" => "PUT Method Succsess ",
                    "data" => $product
                ]
            );
        }
        return response()->json(
            [
                "message" => "Product with id " . $id . " not found"
            ], 400
        );
    }

    function delete($id)
    {
        $product = Product::where('id', $id)->first();
        if($product) {
            $product->delete();
            return response()->json(
                [
                    "message" => "DELETE Product id " . $id . " Success"
                ]
            );
        }
        return response()->json(
            [
                "message" => "Product with id " . $id . " not found"
            ], 400
        );
    }

    public function index()
    {
        $data_product=Product::all();
        return view('pages.products', compact('data_product'));
    }
}
