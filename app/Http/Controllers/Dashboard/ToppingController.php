<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToppingRequest;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToppingController extends Controller
{
    public function index()
    {
        $toppings = Topping::paginate(10);
        return view('toppings.index', compact('toppings'));
    }

    public function create()
    {
        return view('toppings.create');
    }

    public function store(ToppingRequest $request)
    {
        $validated_data = $request->validated();

        $validated_data['img'] = $request->file('img')->store('toppings', 'public');

        Topping::create($validated_data);

        return redirect()->route('toppings.index')->with('message', 'Topping created successfully');
    }

    public function edit(Topping $topping)
    {
        return view('toppings.edit', compact('topping'));
    }

    public function update(ToppingRequest $request, Topping $topping)
    {
        $data = $request->validated();

        if ($request->hasFile('img')) {

            if ($topping->img && Storage::exists($topping->img)) {
                Storage::delete($topping->img);
            }

            $data['img'] = $request->file('img')->store('toppings', 'public');
        } 

        $topping->update($data);

        return redirect()->route('toppings.index')->with('message', 'Topping updated successfully!');
    }

    public function destroy(Topping $topping)
    {
        if ($topping->img && Storage::exists('public/'.$topping->img)) {
            Storage::delete('public/'.$topping->img);
        }
        $topping->delete();
        return redirect()->route('toppings.index')->with('message', 'Topping deleted successfully');
    }
}
