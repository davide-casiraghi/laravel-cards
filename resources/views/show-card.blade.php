

@if ($card)
    <div class="row laravel-card" style="{{$cardParameters['bkg_color']}} {{$cardParameters['text_color']}}">
        @if ($cardParameters['container_wrap'])
            <div class="container">
        @endif
        
        <div class="text {{$cardParameters['text_col_size_class']}} my-auto px-4 {{$cardParameters['text_col_order_class']}}">
            <h2 class="laravel-card-heading mt-5">{{$card['title']}}</h2>
            <div class="lead mb-4">{!!$card['body']!!}</div>
        </div>
        
        @if ($card['introimage'])
            <div class="image d-none d-md-block {{$cardParameters['img_col_size_class']}} {{$cardParameters['img_col_order_class']}}"
                    style="
                    background-image: url(/storage/images/cards_intro_images/{{$card['introimage']}});
                    ">
            </div>

            <div class="image col-12 d-md-none {{$cardParameters['img_col_order_class']}}">
                <img class="laravel-card-image img-fluid mx-auto" src="/storage/images/cards_intro_images/{{$card['introimage']}}" alt="{{$card['introimage_alt']}}">
            </div>
        @endif
        
        
        @if ($cardParameters['container_wrap'])
            </div>
        @endif
    </div>
    
@else
    <div class="alert alert-warning" role="alert">The card with id {{$cardParameters['card_id']}} has not been found.</div>
@endif
