<?php

namespace App\Http\Controllers;

use App\Models\Category;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(): \Inertia\Response
    {
        return Inertia::render('Categories/Index', [
            "categories" => Category::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Categories/Create');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->getValidate($request);

        $category = new Category;

        $category->title = $request->input('title');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');

        if($request->file('image')) {
            $category->image = $this->upload($request);
        }

        $category->save();

        $request->session()->flash('success', 'Category created successfully!');

        return redirect()->route('category.index');
    }

    public function edit($id): \Inertia\Response
    {
        return Inertia::render('Categories/Edit', [
            'category' => Category::findOrFail($id)
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->getValidate($request, $id);

        $category = Category::find($id);

        $category->title = $request->input('title');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');

        if($request->file('image')) {
            $category->image = $this->upload($request);
        }

        $category->save();

        $request->session()->flash('success', 'Category updated successfully!');

        return redirect()->route('category.index');
    }

    public function destroy(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        Category::find($id)->delete();

        $request->session()->flash('success', 'Category deleted successfully!');

        return redirect()->route('category.index');
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
            'description' => 'required'
        ];

        $this->validate($request, $data);
    }

    private function upload(Request $request)
    {
        return Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'Categories'
        ])->getSecurePath();
    }
}
