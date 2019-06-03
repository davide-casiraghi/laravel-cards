@extends('laravel-cards::jumbotronImages.layout')

@section('content')
    
    @if($jumbotronImage)
        {{$jumbotronImage->title}}<br />
        {{$jumbotronImage->body}}<br />
        {{$jumbotronImage->button_text}}<br />
        @if(!empty($jumbotronImage->image_file_name))
            <img class="ml-3 float-right img-fluid mb-2" src="/storage/images/jumbotron_images/thumb_{{ $jumbotronImage->image_file_name }}" ><br />
        @endif
        {{$jumbotronImage->button_url}}<br />
    @else
        <div class="alert alert-warning" role="alert">
            No jumbotron corresponding to the specified ID has been found.
        </div>
    @endif
@endsection
