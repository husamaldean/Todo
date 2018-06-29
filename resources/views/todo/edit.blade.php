@extends('layout')

@section('content')
    <section class="content-header">
        <h1>
            @if($url==='todo')
                Todo Task
            @else
                Todo Mirror
            @endif
        </h1>
    </section>

    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="box box-primary">
            <form method="POST" action="{{url($url.'/'.$todo->id)}}">
                {{ csrf_field() }}
                <div class="form-group" >
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="{{$todo->name}}">
                </div>
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="desc">Description</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3">
                        @if(isset($todo->desc))
                        {{$todo->desc}}
                        @endif
                    </textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    <span class="fa fa-save" role="presentation" aria-hidden="true"></span>
                    Save and back</button>
                <button type="button" class="btn btn-default" onclick="window.location='{{ URL::previous() }}'">
                    <span class="fa fa-ban"></span>
                    Cancel</button>
            </form>
        </div>
    </div>
@endsection
