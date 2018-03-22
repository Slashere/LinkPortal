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
                    {{--<button id="test" href="http://laravel.loc/?page={{request()->page}}">--}}
                        {{--{{request()->page}}--}}
                    {{--</button>--}}

                @endif
            </div>
        </div>
    </div>

    <script type="text/javascript">
$(function(){
    var page = 2;
        $(window).scroll(function () {
            var scrollHeight = $(window).scrollTop() + $(window).height()+1;
            var sectionHeight = $("body").height();
            if (scrollHeight >= sectionHeight) getData();

            function getData() {
                var url = ('http://laravel.loc/?page=' + page);
                    // $('.links').append('<img style="position: absolute; left: 40%; top: 90%; z-index: 100000;" src="/loading.gif" />');
                getLinks(url);
                page++;
            }

            console.log(sectionHeight);
            console.log(scrollHeight);
            console.log($("#test").attr("href"));
            function getLinks(url) {
                $.ajax({
                    url: url
                }).done(function (data) {
                    // if (!$.trim(data)) {
                    //     $("#test").hide();
                    // } else {
                        $('.links').append(data);
                    // }
                }).fail(function () {
                    alert('Link could not be loaded.');
                });
            }
        })
});

        // $(function() {
        //     var i = 1;
        //
        //     $('body').on('click', '#test', function(e) {
        //         e.preventDefault();
        //         // $('#load a').css('color', '#dfecf6');
        //         // $('#load').append('<img style="position: absolute; left: 40%; top: 40%; z-index: 100000;" src="/loading.gif" />');
        //         var url = $(this).attr('href');
        //         getLinks(url);
        //         i++;
        //         $("#test").attr("href", 'http://laravel.loc/?page=' + i);
        //         $("#test").html(i);
        //     });
        //
        //     function getLinks(url) {
        //         $.ajax({
        //             url: url
        //         }).done(function (data) {
        //             if (!$.trim(data)) {
        //                 $("#test").hide();
        //             } else {
        //                 $('.links').append(data);
        //             }
        //         }).fail(function () {
        //             alert('Link could not be loaded.');
        //         });
        //     }
        // });
    </script>
@endsection

