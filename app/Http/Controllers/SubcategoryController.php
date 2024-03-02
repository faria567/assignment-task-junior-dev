<?php
namespace App\Http\Controllers;
use App\Models\subcategory;

use Illuminate\Http\Request;

class subcategoryController extends Controller
{
    
    public function index()
    {
        
        $categories = Subcategory::latest()->paginate(10);
        return view('subcategory.index',compact('categories'));
    }
    
    
    
    public function create()
    {
        return view('subcategory.index');
    }

    

    public function store(Request $request)
    {
       $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'image|mimes:jpeg,gif,png,jpg',
       
       ]);

       $subcategory         = new Subcategory();
       $subcategory->title   = $request->title;
       if ($request->hasFile('image')) {
            $ext = $request->file('image')->extension();
            $final_name = time().'-'.uniqid().'-'.'image'.'.'.$ext;

            $request->file('image')->move(public_path('subcategory/'), $final_name);

            $subcategory->image = $final_name;
        }
       
       
       $subcategory->save();

       return redirect()->back()->with('success', 'You have add new subcategory');
    }


    public function edit(Subcategory $subcategory)
    {
        return view('subcategory.edit', compact('subcategory'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        
            $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'image|mimes:jpeg,gif,png,jpg',
               
        ]);
        
        $subcategory->title   = $request->title;
        if ($request->hasFile('image')) {
            if ($subcategory->image != null) {
                    unlink(public_path('subcategory/'.$subcategory->image));
            }
            $ext = $request->file('image')->extension();
            $final_name = time().'-'.uniqid().'-'.'image'.'.'.$ext;
    
            $request->file('image')->move(public_path('subcategory/'), $final_name);
    
            $subcategory->image = $final_name;
        }

      
        $subcategory->update();
        
        return redirect()->route('subcategory.index')->with('success', 'subcategory updated successfully');
    }

   

    public function destroy(Subcategory $subcategory)
    {
       
        
       if ($subcategory->image != null) {
                unlink(public_path('subcategory/'.$subcategory->image));
        }
       $subcategory->delete();

       return redirect()->back()->with('success', 'You have deleted the subcategory');


        
    }
}
