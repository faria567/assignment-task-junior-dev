<?php
namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index()
    {
        
        $categories = Category::latest()->paginate(10);
        return view('Category.index',compact('categories'));
    }
    
    
    
    public function create()
    {
        return view('Category.index');
    }

    

    public function store(Request $request)
    {
       $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'image|mimes:jpeg,gif,png,jpg',
       
       ]);

       $category         = new Category();
       $category->title   = $request->title;
       if ($request->hasFile('image')) {
            $ext = $request->file('image')->extension();
            $final_name = time().'-'.uniqid().'-'.'image'.'.'.$ext;

            $request->file('image')->move(public_path('category/'), $final_name);

            $category->image = $final_name;
        }
       
       
       $category->save();

       return redirect()->back()->with('success', 'You have add new category');
    }


    public function edit(Category $category)
    {
        return view('Category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        
            $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'image|mimes:jpeg,gif,png,jpg',
               
        ]);
        
        $category->title   = $request->title;
        if ($request->hasFile('image')) {
            if ($category->image != null) {
                    unlink(public_path('category/'.$category->image));
            }
            $ext = $request->file('image')->extension();
            $final_name = time().'-'.uniqid().'-'.'image'.'.'.$ext;
    
            $request->file('image')->move(public_path('category/'), $final_name);
    
            $category->image = $final_name;
        }

      
        $category->update();
        
        return redirect()->route('Category.index')->with('success', 'Category updated successfully');
    }

   

    public function destroy(Category $category)
    {
       
        
       if ($category->image != null) {
                unlink(public_path('category/'.$category->image));
        }
       $category->delete();

       return redirect()->back()->with('success', 'You have deleted the category');


        
    }
}
