<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('id', 'name', 'description', 'price')->orderBy('created_at', 'desc'); 
    
            return DataTables::of($data)
                ->addIndexColumn() 
                ->editColumn('price', function ($row) {
                    return '$' . number_format($row->price, 2); 
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('product.show', $row->id) . '" class="btn btn-sm btn-primary">View</a>';
                })
                ->rawColumns(['action']) 
                ->make(true); 
        }
    
        return view('products.index'); 
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $image='';
        if($request->hasFile('image')){
            $image=time(). '.' . $request->image->extension();
            $request->image->move('images/Product/',$image);
        }
        $product=Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'image'=>$image,
            'description'=>$request->description,
            
        ]);
        if($product){
            return redirect()->route('product.index')->with('success','Successfully Inserted');
        }else{
            return redirect()->back()->with('error','Not Inserted');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('Products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $pdct=Product::find($product);
        return view('Products.edit',compact('pdct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $pdct=Product::find($product);
        if($request->file('image')){
            $file_name=time().".".$request->image->extension();
            $request->image->move('images/Products/', $file_name);
            $pdct->image = $file_name;
        }
        $pdct->name=$request->name;
        $pdct->price=$request->price;
        $pdct->description=$request->description;

        if($pdct->save()){
            return redirect()->route('product.edit',['product'=>$request->id])->with('success','updated successfully');
        }else{
            return redirect()->back()->with('error','Not Updated');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        
        $product->delete();
        return redirect()->back()->with('success','Deleted successfully');
    }


 
}
