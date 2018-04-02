@extends('crud::edit')

@section('above-fields')
    <div class="col-12">
        <div id="images" class="row"></div>
    </div>
@endsection

@push('scripts')
    <script>
        $.get('/story/{{ $entity->id }}/images', function (images) {
            $.each(images.data, function (i, image) {
                $('#images').append('<div class="col-3"><figure class="figure"><img class="figure-img img-fluid rounded" src="' + image.thumb + '"><figcaption class="figure-caption">' + image.name + '</figcaption></figure></div>');
            });
        })
    </script>
@endpush