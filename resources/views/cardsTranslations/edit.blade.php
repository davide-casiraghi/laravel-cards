@extends('laravel-cards::jumbotronImages.layout')

@section('content')
    
    <div class="row py-4">
        <div class="col-12 col-sm-9">
            <h4>Edit jumbotron image translation</h4>
        </div>
        <div class="col-12 col-sm-3 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('laravel-cards::partials.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('jumbotron-images-translation.update', $jumbotronImageTranslation->id) }}" method="POST">
        @csrf
        @method('PUT')
            @include('laravel-cards::partials.input-hidden', [
                  'name' => 'jumbotron_image_translation_id',
                  'value' => $jumbotronImageTranslation->id,
            ])
            @include('laravel-cards::partials.input-hidden', [
                  'name' => 'jumbotron_image_id',
                  'value' => $jumbotronImageId,
            ])
            @include('laravel-cards::partials.input-hidden', [
                  'name' => 'language_code',
                  'value' => $languageCode
            ])

         <div class="row">
            <div class="col-12">
                @include('laravel-cards::partials.input', [
                    'title' =>  'Title',
                    'name' => 'title',
                    'placeholder' => '', 
                    'value' => $jumbotronImageTranslation->title,
                    'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-cards::partials.textarea-plain', [
                    'title' =>  'Body',
                    'name' => 'body',
                    'value' => $jumbotronImageTranslation->body,
                    'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-cards::partials.input', [
                    'title' =>  'Button text',
                    'name' => 'button_text',
                    'placeholder' => '', 
                    'value' => $jumbotronImageTranslation->button_text,
                    'required' => true,
                ])
            </div>
        </div>
        
        <div class="row mt-2">  
            <div class="col-12 action">
                @include('laravel-cards::partials.buttons-back-submit', [
                    'route' => 'jumbotron-images.index'  
                ])
    </form>

                <form action="{{ route('jumbotron-images-translation.destroy',$jumbotronImageTranslation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link pl-0">Delete translation</button>
                </form>
            </div>
        </div>

@endsection        
        
