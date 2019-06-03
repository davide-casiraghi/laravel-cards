@extends('laravel-cards::cards.layout')

@section('content')
    
    <div class="row py-4">
        <div class="col-12 col-sm-9">
            <h4>Edit jumbotron image translation</h4>
        </div>
        <div class="col-12 col-sm-3 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('laravel-form-partials::error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('laravel-cards-translation.update', $cardTranslation->id) }}" method="POST">
        @csrf
        @method('PUT')
            @include('laravel-form-partials::input-hidden', [
                  'name' => 'jumbotron_image_translation_id',
                  'value' => $cardTranslation->id,
            ])
            @include('laravel-form-partials::input-hidden', [
                  'name' => 'card_id',
                  'value' => $cardId,
            ])
            @include('laravel-form-partials::input-hidden', [
                  'name' => 'language_code',
                  'value' => $languageCode
            ])

         <div class="row">
             <div class="col-12">
                 @include('laravel-form-partials::input', [
                     'title' => 'Heading',
                     'name' => 'heading',
                     'placeholder' => '', 
                     'value' => $cardTranslation->heading,
                     'required' => true,
                 ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::input', [
                    'title' =>  'Title',
                    'name' => 'title',
                    'placeholder' => '', 
                    'value' => $cardTranslation->title,
                    'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::textarea-plain', [
                    'title' =>  'Body',
                    'name' => 'body',
                    'value' => $cardTranslation->body,
                    'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-form-partials::input', [
                    'title' =>  'Button text',
                    'name' => 'button_text',
                    'placeholder' => '', 
                    'value' => $cardTranslation->button_text,
                    'required' => true,
                ])
            </div>
        </div>
        
        <div class="row mt-2">  
            <div class="col-12 action">
                @include('laravel-form-partials::buttons-back-submit', [
                    'route' => 'laravel-cards.index'  
                ])
    </form>

                <form action="{{ route('laravel-cards-translation.destroy',$cardTranslation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link pl-0">Delete translation</button>
                </form>
            </div>
        </div>

@endsection        
        
