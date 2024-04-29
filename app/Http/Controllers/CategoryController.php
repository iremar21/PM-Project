<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Devuelve un listado de todas las categorías
    public function index() {

        $categories = Category::paginate(10);

        return view('admin/categories/index', compact('categories'));

    }

    // Devuelve la vista con el formulario para crear una nueva categoría
    public function create() {

        return view('admin/categories/create');

    }

    // Guarda la nueva categoría
    public function store(Request $request) {

        $category = new Category();

        $category->name = $request->name;

        $category->save();

        return redirect()->route('categories');

    }

    // Buscar categorías por nombre
    public function search(Request $request) {

        $search = $request->search;

        $categories = Category::where(function($query) use ($search) {

            $query->where('name','like',"%$search%");

        })->paginate(10);

        return view('admin/categories/index', compact('categories', 'search'));

    }

    // Borra la categoría que se le pasa
    // Si la categoría ya ha sido asignada a algún plan, devuelve un mensaje de error
    public function destroy(Category $category) {

        try {

            $category->delete();

            $categories = Category::paginate(10);

            return redirect()->route('categories', compact('categories'));

        } catch (Exception $e) {
            
            $categories = Category::paginate(10);

            $message = 'La categoría seleccionada no se puede eliminar porque ha sido asignada a uno o más planes.';

            return redirect()->route('categories', compact('categories'))->withError($message);
        }

    }
}
