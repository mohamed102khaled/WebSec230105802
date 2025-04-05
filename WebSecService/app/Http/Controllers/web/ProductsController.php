<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth; // ✅ Fix: Correctly import Auth

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('list');
    }

    public function edit(Request $request, Product $product = null)
    {
        $product = $product ?? new Product();
        return view("products.add", compact('product'));
    }

    public function save(Request $request, Product $product = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code,' . ($product ? $product->id : 'NULL'),
            'model' => 'required|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $product = $product ?? new Product();
        $product->name = $request->name;
        $product->code = $request->code;
        $product->model = $request->model;
        $product->price = $request->price;
        $product->photo = $request->photo;
        $product->description = $request->description;

        $product->save();

        return redirect()->route('products_list')->with('success', 'Product saved successfully.');
    }

    public function delete(Request $request, Product $product)
    {
        if (!auth()->user()->hasPermissionTo('delete_products')) {
            abort(401);
        }
        $product->delete();
        return redirect()->route('products_list');
    }

    public function list(Request $request)
    {
        $query = Product::select("products.*");

        $query->when($request->keywords, function ($q) use ($request) {
            $q->where("name", "like", "%" . $request->keywords . "%");
        });

        $query->when($request->min_price, function ($q) use ($request) {
            $q->where("price", ">=", $request->min_price);
        });

        $query->when($request->max_price, function ($q) use ($request) {
            $q->where("price", "<=", $request->max_price);
        });

        $query->when($request->order_by, function ($q) use ($request) {
            $q->orderBy($request->order_by, $request->order_direction ?? "ASC");
        });

        $products = $query->get();

        return view("products.list", compact('products'));
    }

    public function buy(Product $product, Request $request)
    {
        $user = Auth::user(); // Get the logged-in user
    
        // Ensure only customers can buy
        if (!$user->hasRole('customer')) {
            return redirect()->back()->with('error', 'Only customers can purchase products.');
        }
    
        // Check if the user has enough credit
        if ($user->credit < $product->price) {
            return view('products.insufficient_credit', compact('user', 'product'));
        }
    
        // Deduct product price from user credit
        $user->credit -= $product->price;
        $user->save();
    
        // Save purchase order in "bought products" (Ensure you have a `bought_products` table)
        $user->boughtProducts()->attach($product->id, [
            'quantity' => 1,
            'total_price' => $product->price,
            'status' => 'purchased',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->back()->with('success', 'Product purchased successfully!');
    }
}
