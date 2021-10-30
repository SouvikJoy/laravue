<?php

namespace App\Http\Controllers;

use App\Models\Service;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(): \Inertia\Response
    {
        return Inertia::render('Services/Index', [
            "services" => Service::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Services/Create');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->getValidate($request);

        $service = new Service;

        $service->title = $request->input('title');
        $service->description = $request->input('description');

        if($request->file('image')) {
            $service->image = $this->upload($request);
        }

        $service->save();

        $request->session()->flash('success', 'Service created successfully!');

        return redirect()->route('service.index');
    }

    public function edit($id): \Inertia\Response
    {
        return Inertia::render('Services/Edit', [
            'service' => Service::findOrFail($id)
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->getValidate($request, $id);

        $service = Service::find($id);

        $service->title = $request->input('title');
        $service->description = $request->input('description');

        if($request->file('image')) {
            $service->image = $this->upload($request);
        }

        $service->save();

        $request->session()->flash('success', 'Service updated successfully!');

        return redirect()->route('service.index');
    }

    public function destroy(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        Service::find($id)->delete();

        $request->session()->flash('success', 'Service deleted successfully!');

        return redirect()->route('service.index');
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
            'description' => 'required'
        ];

        $this->validate($request, $data);
    }

    private function upload(Request $request)
    {
        return Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'Services'
        ])->getSecurePath();
    }
}
