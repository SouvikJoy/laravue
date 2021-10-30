<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Index', [
            "products" => Product::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
        $this->getValidate($request);

        $product = new Product();

        $product->title = $request->input('title');
        $product->slug = $request->input('slug');
        $product->brief = $request->input('brief');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if($request->file('image')) {
            $product->image = $this->upload($request);
        }

        $product->save();

        $request->session()->flash('success', 'Product created successfully!');

        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        return Inertia::render('Products/Edit', [
            'product' => Product::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->getValidate($request, $id);

        $product = Product::find($id);

        $product->title = $request->input('title');
        $product->slug = $request->input('slug');
        $product->brief = $request->input('brief');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if($request->file('image')) {
            $product->image = $this->upload($request);
        }

        $product->save();

        $request->session()->flash('success', 'Product updated successfully!');

        return redirect()->route('product.index');
    }

    public function destroy(Request $request, $id)
    {
        Product::find($id)->delete();

        $request->session()->flash('success', 'Product deleted successfully!');

        return redirect()->route('product.index');
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    private function getValidate(Request $request, $id = null): void
    {
        $data = [
            'title' => 'required',
            'slug' => 'required',
            'brief' => 'required',
            'description' => 'required',
            'price' => 'required',
        ];

        $this->validate($request, $data);
    }

    private function upload(Request $request)
    {
        $imageName = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();

        return $imageName;
    }
}
