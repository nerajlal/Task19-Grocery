<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $families = Attribute::where('type', 'family')->latest()->get();
        $notes = Attribute::where('type', 'note')->latest()->get();
        return view('admin.attributes.index', compact('families', 'notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:family,note',
            'color' => 'nullable|string|max:50',
        ]);

        Attribute::create($request->all());

        return redirect()->back()->with('success', ucfirst($request->type) . ' added successfully.');
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
        ]);

        $attribute->update($request->only('name', 'color'));

        return redirect()->back()->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        Attribute::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}
