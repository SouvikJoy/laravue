<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        return Inertia::render('Categories/Index', [
            "categories" => Category::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store(Request $request)
    {
        $this->getValidate($request);

        $category = new Category;

        $category->title = $request->input('title');
        $category->content = $request->input('content');

        if($request->file('image')) {
            $category->image = $this->upload($request);
        }

        $category->save();

        $request->session()->flash('success', 'Category created successfully!');

        return redirect()->route('category.index');
    }

    public function edit($id)
    {
        return Inertia::render('Categories/Edit', [
            'category' => Category::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->getValidate($request, $id);

        $category = Category::find($id);

        $category->title = $request->input('title');
        $category->content = $request->input('content');

        if($request->file('image')) {
            $category->image = $this->upload($request);
        }

        $category->save();

        $request->session()->flash('success', 'Category updated successfully!');

        return redirect()->route('category.index');
    }

    public function destroy(Request $request, $id)
    {
        Category::find($id)->delete();

        $request->session()->flash('success', 'Category deleted successfully!');

        return redirect()->route('category.index');
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    private function getValidate(Request $request, $id = null): void
    {
        $data = [
            'title' => 'required',
            'content' => 'required'
        ];

        $this->validate($request, $data);
    }

    private function upload($request)
    {
        $image = $request->file('image');

        $imageName = md5(uniqid()) . "." . $image->getClientOriginalExtension();

        $image->move(public_path('uploads'), $imageName);

        return $imageName;
    }
}
