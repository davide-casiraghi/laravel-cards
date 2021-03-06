@extends('laravel-cards::cards.layout')

@section('content')
    {{--
    @if($card)
        {{$card->heading}}<br />
        {{$card->title}}<br />
        {{$card->body}}<br />
        {{$card->button_text}}<br />
        @if(!empty($card->image_file_name))
            <img class="ml-3 float-right img-fluid mb-2" src="/storage/images/cards/thumb_{{ $card->image_file_name }}" ><br />
        @endif
        {{$card->button_url}}<br />
    @else
        <div class="alert alert-warning" role="alert">
            No card corresponding to the specified ID has been found.
        </div>
    @endif
    --}}
    
    @include('laravel-cards::show-card', [
         'card' => $card,
         'cardParameters' => $cardParameters,
   ])
    
@endsection
