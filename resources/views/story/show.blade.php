@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 mx-auto">
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
        var scenes = {!! json_encode($story->scenes) !!};

        function show(scene) {
            $('#scene h5').text(scene.title);
            $('#scene p').html(scene.body.replace(/\n/g, '<br>'));

            $('#scene ul').html('');
            scene.passages.forEach(function (passage) {
                $('#scene ul').append('<li><a data-id="'
                    + passage.target_id + '" href="#">' + passage.title + '</a></li>');
            });
        }

        $('#passages').on('click', 'a', function () {
            var target_id = $(this).data('id');

            scenes.forEach(function (scene) {
                if (target_id == scene.id) {
                    show(scene);
                    return;
                }
            });
        });

        show(scenes[0]);

    </script>
@endpush