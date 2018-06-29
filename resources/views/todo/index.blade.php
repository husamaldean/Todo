@extends('layout')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <section class="content-header">
        <h1 class="pull-left">
            @if($url==='todo')
                Todo Task
            @else
                Todo Mirror
            @endif
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-header">
                <a class="btn btn-primary" style="margin-top: -10px;margin-bottom: 5px" href="{{ url($url.'/create') }}">
                    <i class="glyphicon glyphicon-plus">Add New
                        @if($url==='todo')
                            Todo
                        @else
                            Todo Mirror
                        @endif
                    </i>
                </a>
            </div>
            <div class="table-responsive">

            <table class="table able-hover col-lg-12">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th colspan="3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($todos as $todo)
                        <tr>
                            <td>{!! $todo->name !!}</td>
                            <td>{!! $todo->desc !!}</td>
                            <td>{!! $todo->created_at !!}</td>
                            <td>{!! $todo->updated_at !!}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <a class="btn btn-default btn-xs" href="{{ url($url.'/'.$todo->id.'/edit') }}"><i class="glyphicon glyphicon-edit"></i></a>
                                    <div class="col-xs-2">
                                    <form action="{{ url($url.'/'.$todo->id) }}" method="POST">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure you want to delete?')"><i class="glyphicon glyphicon-trash"></i></button>
                                    </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $todos->links() }}
        <div class="text-center">

        </div>
    </div>
@endsection