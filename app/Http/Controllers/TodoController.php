<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use App\Models\TodoMirror;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Alert;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('todo.index',['todos'=> ToDo::paginate(10)])->with('url','todo');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create')->with('url','todo');
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
            'name' => 'required|unique:todos,name,'.$request->route('todo').'|max:255',
        ]);
        try {
            ToDo::create(request()->except(['_token']));
            TodoMirror::create(request()->except(['_token']));
            Log::info('successful todo and todo mirror added with name = '.$request->name);
            return redirect('todo')->with('status', 'Your request has been successfully added');
        }catch (\Exception $e)
        {
            Log::error("The user have the below exception : \n".$e);
            Alert::error($e->getMessage())->flash();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToDo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(ToDo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ToDo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(ToDo $todo)
    {
        return view('todo.edit')->with('todo',$todo)->with('url','todo');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToDo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDo $todo)
    {
        $request->validate([
            'name' => 'required|max:255|unique:todos,name,'.$todo->id,
        ]);
        try {
            $todo->name = $request->request->get('name');
            $todo->desc = $request->request->get('desc');
            $todo->save();
            TodoMirror::where('id', $todo->id)->update(request()->except(['_token', '_method']));
            Log::info('successful todo & todo mirror updated with name = ' . $request->name);
            return redirect('todo')->with('status', 'Your request has been successfully updated');
        }catch (\Exception $e)
        {
            Log::error("The user have the below exception : \n".$e);
            Alert::error($e->getMessage())->flash();
            return redirect('todo');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToDo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDo $todo)
    {
        try {
            $todo->delete();
            TodoMirror::where('id', $todo->id)->delete();
            Log::info('successful todo and todo mirror deleted with name = ' . $todo->name);
            return redirect('todo')->with('status', 'Your request has been successfully deleted');
        }catch (\Exception $e)
        {
            Log::error("The user have the below exception : \n".$e);
            Alert::error($e->getMessage())->flash();
            return redirect('todo');

        }

    }
}
