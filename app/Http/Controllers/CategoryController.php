<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'autocomplete']);
    }

    public function index()
    {
        return view('categories.list', [
            'categories' => Category::orderBy('title', 'asc')->paginate(10)
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:50', 'unique:categories,title'],
            'description' => ['required', 'string', 'max:160']
        ]);
        $category = Category::create($validatedData);
        return redirect()->route('categories.show', $category);
    }

    public function show(Category $category)
    {
        return view('categories.posts', [
            'category' => $category,
            'posts' => $category->posts()->orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact($category));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:50', 'unique:categories,title'],
            'description' => ['required', 'string', 'max:160']
        ]);
        $category->fill($validatedData);
        $category->save();
        return redirect()->route('categories.show', $category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }

    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
        $fromMiddle = $request->get('middle', false);
        if ($fromMiddle)
            $categories = Category::where('title', 'LIKE', "%$term%")->orderBy('title', 'asc')->take(5)->get();
        else
            $categories = Category::where('title', 'LIKE', "$term%")->orderBy('title', 'asc')->take(5)->get();
        return response()->json(array_map(function ($category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
                'summary' => $category->description
            ];
        }, $categories));
    }
}
