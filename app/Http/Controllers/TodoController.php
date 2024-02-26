<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if(isset($search)) {
            $todos = Todo::where('title', 'like', "%$search%")->get();
        } else {
            $todos = Todo::all();
        }

        return view('todos', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3',
        ]);

        Todo::create([
            'title' => $request->get('title'),
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('todos.index')->with('success', 'Todo Inserted!');
    }

    public function edit($id) {
        $todo = Todo::where('id', $id)->first();
        $this->authorize('update', $todo);
        return view('edit-todo', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::where('id', $id)->first();
        $updatedTodo = $request->validate([
            'title' => 'required|string|min:3'
        ]);

        $todo->is_completed = $request->is_completed;
        $todo->update($updatedTodo);
        return redirect()->route('todos.index')->with('success', 'Todo Updated');
    }

    public function destroy($id)
    {
        $todo = Todo::where('id', $id)->first();
        $this->authorize('delete', $todo);
        $todo->delete();
        return redirect()->route('todos.index')->with('success', 'Todo delete successfully');
    }

//    public function search(Request $request)
//    {
//
//        return view('todos', compact('todos'));
//    }
}
