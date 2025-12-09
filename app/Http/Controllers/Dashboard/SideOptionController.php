<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SideOptionRequest;
use App\Models\SideOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SideOptionController extends Controller
{
    public function index()
    {
        $side_options = SideOption::latest()->paginate(10);

        return view('side_options.index', compact('side_options'));
    }

    public function create()
    {
        return view('side_options.create');
    }

    public function store(SideOptionRequest $request)
    {
        $data = $request->validated();

        $data['img'] = $request->file('img')->store('side_options', 'public');

        SideOption::create($data);

        return redirect()->route('side_options.index')
            ->with('message', 'Side Option Created Successfully!');
    }

    public function edit(SideOption $side_option)
    {
        return view('side_options.edit', compact('side_option'));
    }

    public function update(SideOptionRequest $request, SideOption $side_option)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) {

            if ($side_option->img && Storage::exists('public/'.$side_option->img)) {
                Storage::delete('public/'.$side_option->img);
            }

            $data['img'] = $request->file('img')->store('side_options', 'public');
        } 

        $side_option->update($data);

        return redirect()->route('side_options.index')->with('message', 'Side Option Updated Successfully!');
    }

    public function destroy(SideOption $side_option)
    {
        if ($side_option->img && Storage::exists('public/'.$side_option->img)) {
            Storage::delete('public/'.$side_option->img);
        }

        $side_option->delete();

        return redirect()->route('side_options.index')
            ->with('message', 'Side Option Deleted Successfully!');
    }
}
