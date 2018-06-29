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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content">
        <div class="box box-primary">
            <form method="POST" action="{{url($url)}}">
                {{ csrf_field() }}
                <div class="form-group" >
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <label for="desc">Description</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
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
