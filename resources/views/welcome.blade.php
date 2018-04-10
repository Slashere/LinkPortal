@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @can('create-link')
                <a class="btn btn-small btn-success" href="{{ route('create_link') }}">Create Link</a>
            @endcan
            <div class="col-md-8 col-md-offset-2">
                <h2>Links:</h2>
                @if (count($allLinks) > 0)
                    <section class="links">
                @include('prewelcome')
                    </section>
                @endif
            </div>
        </div>
    </div>
@endsection

