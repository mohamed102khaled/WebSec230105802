<?php
 namespace App\Http\Controllers\Web;

 use Illuminate\Http\Request;
 use App\Models\Product;
 use Illuminate\Routing\Controller; // Make sure this is the correct base controller
 
 class ProductsController extends Controller
 {
     public function __construct()
     {
         $this->middleware('auth')->except('list'); // Fix middleware usage
     }
 
     public function edit(Request $request, Product $product = null) {
         $product = $product ?? new Product();
         return view("products.add", compact('product'));
     }
 
     public function save(Request $request, Product $product = null) {
        $this->validate($request, [
            'code' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'model' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:1024'],
            'price' => ['required', 'numeric'],
        ]);
        $product = $product??new Product();
        $product->fill($request->all());
        $product->save();
        return redirect()->route('products_list');
     }
 
     public function delete(Product $product) {
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
 