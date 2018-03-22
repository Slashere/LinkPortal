@foreach ($allLinks as $link)
    <div class="panel panel-default">
        <div class="panel-heading"><a
                    href='{{ route('show_link',$link->id) }}'>Title: {{$link->title}}</a></div>
        <div class="panel-body">
            <p>Link: {{$link->link}}</p>
            <p>User: <a href="{{route('show_user',$link->user_id)}}">{{$link->user->name}}</a></p>
            <p>Description: {{$link->description}}</p>
            @can('update-link', $link)
                <p>Private: {{$link->private}}</p>
            @endcan
            @can('update-link', $link)
                <a class="btn btn-small btn-success" href="{{ route('edit_link', $link->id) }}">Edit
                    this
                    Link</a>
            @endcan
            @can('delete-link', $link)
            <!-- Delete should be a button -->
                {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['delete_link', $link->id],
                        'onsubmit' => "return confirm('Are you sure you want to delete?')",
                    ]) !!}
                {!! Form::submit('Delete',['class' => 'btn btn-small btn-danger']) !!}
                {!! Form::close() !!}
            <!-- End Delete button -->
            @endcan
        </div>

    </div>

@endforeach
