<?php

namespace Acme\CmsDashboard\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Acme\CmsDashboard\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('posts')->orderBy('name');
        
        if ($request->has('s')) {
            $query->where('name', 'like', '%' . $request->s . '%')
                  ->orWhere('description', 'like', '%' . $request->s . '%');
        }

        $categories = $query->paginate(10);
        return view('cms-dashboard::admin.categories.index', compact('categories'));
    }

    public function bulk(Request $request)
    {
        $action = $request->input('action') !== '-1' ? $request->input('action') : $request->input('action2');
        $ids = $request->input('ids');

        if (($action === 'delete') && !empty($ids)) {
            Category::whereIn('id', $ids)->delete();
            return back()->with('success', 'Selected categories deleted.');
        }

        return back()->with('error', 'Please select an action and at least one item.');
    }

    public function store(Request $request)
    {
        $baseSlug = $request->slug ?: $request->name;
        $request->merge(['slug' => Category::generateUniqueSlug($baseSlug)]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category added.');
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->orderBy('name')->get();
        return view('cms-dashboard::admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $baseSlug = $request->slug ?: $request->name;
        $request->merge(['slug' => Category::generateUniqueSlug($baseSlug, $category->id)]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
