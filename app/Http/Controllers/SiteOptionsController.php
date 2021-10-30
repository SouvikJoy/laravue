<?php

namespace App\Http\Controllers;

use App\Models\SiteOption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteOptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        return Inertia::render('SiteOptions/Index', [
            "siteoptions" => SiteOption::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('SiteOptions/Create');
    }

    public function store(Request $request)
    {
        $this->getValidate($request);

        $siteoption = new SiteOption();

        $siteoption->title = $request->input('title');
        $siteoption->content = $request->input('content');

        $siteoption->save();

        $request->session()->flash('success', 'SiteOption created successfully!');

        return redirect()->route('siteoption.index');
    }

    public function edit($id)
    {
        return Inertia::render('SiteOptions/Edit', [
            'siteoption' => SiteOption::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->getValidate($request, $id);

        $siteoption = SiteOption::find($id);

        $siteoption->title = $request->input('title');
        $siteoption->content = $request->input('content');

        $siteoption->save();

        $request->session()->flash('success', 'SiteOption updated successfully!');

        return redirect()->route('siteoption.index');
    }

    public function destroy(Request $request, $id)
    {
        SiteOption::find($id)->delete();

        $request->session()->flash('success', 'SiteOption deleted successfully!');

        return redirect()->route('siteoption.index');
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
}
