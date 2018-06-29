<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use App\Models\TodoMirror;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Alert;
class TodoMirrorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('todo.index',['todos'=> TodoMirror::paginate(10)])->with('url','todo_mirror');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create')->with('url','todo_mirror');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:todo_mirrors,name,'.$request->route('todo_mirror').'|max:255',
        ]);
        try {
            ToDo::create(request()->except(['_token']));
            TodoMirror::create(request()->except(['_token']));
            Log::info('successful todo and todo mirror added with name = '.$request->name);
            return redirect('todo_mirror')->with('status', 'Your request has been successfully added');
        }catch (\Exception $e)
        {
            Log::error("The user have the below exception : \n".$e);
            Alert::error($e->getMessage())->flash();
            return redirect('todo_mirror');

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TodoMirror  $todoMirror
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoMirror $todoMirror)
    {
        return view('todo.edit')->with('todo',$todoMirror)->with('url','todo_mirror');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TodoMirror  $todoMirror
     * @return \Illuminate\Http\Response
     */
    public function show(TodoMirror $todoMirror)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TodoMirror  $todoMirror
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoMirror $todoMirror)
    {
        $request->validate([
            'name' => 'required|unique:todo_mirrors,name,'.$todoMirror->id.'|max:255',
        ]);
        try {
            $todoMirror->name = $request->request->get('name');
            $todoMirror->desc = $request->request->get('desc');
            $todoMirror->save();
            ToDo::where('id', $todoMirror->id)->update(request()->except(['_token', '_method']));
            Log::info('successful todo & todo mirror updated with name = ' . $request->name);
            return redirect('todo_mirror')->with('status', 'Your request has been successfully updated');
        }catch (\Exception $e)
        {
            Log::error("The user have the below exception : \n".$e);
            Alert::error($e->getMessage())->flash();
            return redirect('todo_mirror');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoMirror  $todoMirror
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoMirror $todoMirror)
    {
        try {
            $todoMirror->delete();
            ToDo::where('id', $todoMirror->id)->delete();
            Log::info('successful todo and todo mirror deleted with name = ' . $todoMirror->name);
            return redirect('todo_mirror')->with('status', 'Your request has been successfully deleted');
        }catch (\Exception $e)
        {
            Log::error("The user have the below exception : \n".$e);
            Alert::error($e->getMessage())->flash();
            return redirect('todo_mirror');

        }
    }
}
