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

    <script type="text/javascript">
        $(function() {
            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();

                $('#load a').css('color', '#dfecf6');
                $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/loading.gif" />');

                var url = $(this).attr('href');
                getArticles(url);
                window.history.pushState("", "", url);
            });

            function getArticles(url) {
                $.ajax({
                    url : url
                }).done(function (data) {
                    $('.links').html(data);
                }).fail(function () {
                    alert('Articles could not be loaded.');
                });
            }
        });
    </script>
@endsection

