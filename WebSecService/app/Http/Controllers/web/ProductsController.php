<?php
 namespace App\Http\Controllers\Web;

 use Illuminate\Http\Request;
 use App\Models\Product;
 use App\Http\Controllers\Controller;
 
 class ProductsController extends Controller
 {
    public function edit(Request $request, Product $product = null) {
        $product = $product??new Product();
        return view("products.add", compact('product'));
    }

    public function save(Request $request, Product $product = null) {
        $product = $product??new Product();
        $product->fill($request->all());
        $product->save();
        return redirect()->route('products_list');
    }

    public function delete(Request $request, Product $product) {
        $product->delete();
        return redirect()->route('products_list');
    }
    
     public function list(Request $request) 
     {
         $query = Product::select("products.*");
 
         // Search by keywords
         $query->when($request->keywords, function ($q) use ($request) {
             $q->where("name", "like", "%" . $request->keywords . "%");
         });
 
         // Filter by minimum price
         $query->when($request->min_price, function ($q) use ($request) {
             $q->where("price", ">=", $request->min_price);
         });
 
         // Filter by maximum price
         $query->when($request->max_price, function ($q) use ($request) {
             $q->where("price", "<=", $request->max_price);
         });
 
         // Sort by selected column and direction
         $query->when($request->order_by, function ($q) use ($request) {
             $q->orderBy($request->order_by, $request->order_direction ?? "ASC");
         });
 
         // Fetch the filtered products
         $products = $query->get();
 
         return view("products.list", compact('products'));
     }
 }
 
 