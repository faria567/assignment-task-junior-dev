<?php
namespace App\Http\Controllers;
use App\Models\Subcategory;

use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    
    public function index()
    {
        
        $subcategories = Subcategory::latest()->paginate(10);
        return view('subcategory.index',compact('subcategories'));
    }
    
    
    
    public function create()
    {
        return view('subcategory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parentCategory' => 'nullable|string',
            'totalCourse' => 'nullable',
        ]);

        Subcategory::create($request->all());

        return redirect()->route('subcategory.index')->with('success', 'SUb Category created successfully');
    }

    public function edit(Subcategory $subcategory)
    {
        return view('subcategory.edit', compact('subcategory'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parentCategory' => 'nullable|string',
            'totalCourse' => 'nullable',
        ]);

        $subcategory->update($request->all());

        return redirect()->route('subcategory.index')->with('success', 'Sub Category updated successfully');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect()->route('subcategory.index')->with('success', 'Sub Category deleted successfully');
    }
}
