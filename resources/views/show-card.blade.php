

@if ($card)
    <div class="row laravel-card" style="{{$parameters['bkg_color']}} {{$parameters['text_color']}}">
        @if ($parameters['container_wrap'])
            <div class="container">
        @endif
        
        <div class="text {{$parameters['text_col_size_class']}} my-auto px-4 {{$parameters['text_col_order_class']}}">
            <h2 class="laravel-card-heading mt-5">{{$card['title']}}</h2>
            <div class="lead mb-4">{!!$card['body']!!}</div>
        </div>
        
        @if ($card['introimage'])
            <div class="image d-none d-md-block {{$parameters['img_col_size_class']}} {{$parameters['img_col_order_class']}}"
                    style="
                    background-size: cover; 
                    background-image: url(/storage/images/cards_intro_images/{{$card['introimage']}});
                    min-height: 400px;
                    background-position: 50% 50%;
                    ">
            </div>

            <div class="image col-12 d-md-none {{$parameters['img_col_order_class']}}">
                <img class="laravel-card-image img-fluid mx-auto" src="/storage/images/cards_intro_images/{{$card['introimage']}}" alt="{{$card['introimage_alt']}}">
            </div>
        @endif
        
        
        @if ($parameters['container_wrap'])
            </div>
        @endif
    </div>
    
@else
    <div class="alert alert-warning" role="alert">The card with id {{$parameters['card_id']}} has not been found.</div>
@endif
