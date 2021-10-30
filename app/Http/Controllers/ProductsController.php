<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Products/Index', [
            "products" => Product::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Products/Create');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->getValidate($request);

        $product = new Product();

        $this->extracted($request, $product);

        $request->session()->flash('success', 'Product created successfully!');

        return redirect()->route('product.index');
    }

    public function edit($id): \Inertia\Response
    {
        return Inertia::render('Products/Edit', [
            'product' => Product::findOrFail($id)
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->getValidate($request, $id);

        $product = Product::find($id);

        $this->extracted($request, $product);

        $request->session()->flash('success', 'Product updated successfully!');

        return redirect()->route('product.index');
    }

    public function destroy(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        Product::find($id)->delete();

        $request->session()->flash('success', 'Product deleted successfully!');

        return redirect()->route('product.index');
    }

    /**
     * @param Request $request
     * @param null $id
     * @throws ValidationException
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
        return Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'Products'
        ])->getSecurePath();
    }

    /**
     * @param Request $request
     * @param $product
     */
    public function extracted(Request $request, $product): void
    {
        $product->title = $request->input('title');
        $product->slug = $request->input('slug');
        $product->brief = $request->input('brief');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if ($request->file('image')) {
            $product->image = $this->upload($request);
        }

        $product->save();
    }
}
