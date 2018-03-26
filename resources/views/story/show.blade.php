@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-10 mx-auto">

                @include('crud::partials.messages')

                <div class="float-right mt-3">
                    <a href="#" id="start-story"><i class="fa fa-home"></i> Start</a>
                </div>
                <h1>{{ $story->title }}</h1>
                <p>{!! nl2br($story->summary) !!}</p>

                <section id="scene" class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text"></p>
                        <ul id="passages"></ul>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var scenes = {!! json_encode($story->scenes()) !!};

        function show(scene) {
            $('#scene h5').text(scene.title);
            $('#scene p').html(scene.body.replace(/\n/g, '<br>'));

            $('#scene ul').html('');
            scene.passages.forEach(function (passage) {
                $('#scene ul').append('<li><a data-target="'
                    + passage.target + '" href="#">' + passage.title + '</a></li>');
            });
        }

        $('#passages').on('click', 'a', function (e) {
            e.preventDefault();

            var target = $(this).data('target');

            if (typeof scenes[target] === 'undefined') {
                var $msg = $('<div class="alert alert-danger">Szene <strong>' + target + '</strong> nicht gefunden</div>');
                $msg.insertBefore('#scene');
                setTimeout(function () {
                    $msg.fadeOut();
                }, 2000);
            }
            else {
                show(scenes[target]);
            }
        });

        $('#start-story').on('click', function (e) {
            e.preventDefault();
            show(scenes[Object.keys(scenes)[0]]);
        });

        show(scenes[Object.keys(scenes)[0]]);

    </script>
@endpush

@section('page-head')
    <meta name="robots" content="noindex, nofollow">
@endsection