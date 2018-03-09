@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @can('create-link')
                <a class="btn btn-small btn-success" href="{{ route('create_link') }}">Create Link</a>
            @endcan
            <div class="col-md-8 col-md-offset-2">
                @foreach ($allMyLinks as $link)
                    <div class="panel panel-default">
                        <div class="panel-heading"><a
                                    href='{{ route('show_link',$link->id) }}'>Title: {{$link->title}}</a></div>
                        <div class="panel-body">
                            <p>Link: {{$link->link}}</p>
                            <p>UserID: {{$link->user_id}}</p>
                            <p>Description: {{$link->description}}</p>
                            <p>Private: {{$link->private}}</p>
                        </div>

                        @if(Auth::check() && Auth::user()->id == $link->user_id)
                            <a class="btn btn-small btn-success" href="{{ route('edit_link', $link->id) }}">Edit this
                                Link</a>

                            <!-- Delete should be a button -->
                            {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['delete_link', $link->id],
                                    'onsubmit' => "return confirm('Are you sure you want to delete?')",
                                ]) !!}
                            {!! Form::submit('Delete',['class' => 'btn btn-small btn-danger']) !!}
                            {!! Form::close() !!}
                        <!-- End Delete button -->
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
@endsection

