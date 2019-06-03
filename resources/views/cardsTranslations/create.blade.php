@extends('laravel-cards::jumbotronImages.layout')

@section('content')
    
    <div class="row py-4">
        <div class="col-12 col-sm-9">
            <h4>Add new jumbotron image translation</h4>
        </div>
        <div class="col-12 col-sm-3 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('laravel-cards::partials.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('jumbotron-images-translation.store') }}" method="POST">
        @csrf

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
                    'value' => old('title'),
                    'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-cards::partials.textarea-plain', [
                    'title' =>  'Body',
                    'name' => 'body',
                    'value' => old('body'),
                    'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('laravel-cards::partials.input', [
                    'title' =>  'Button text',
                    'name' => 'button_text',
                    'placeholder' => '', 
                    'value' => old('button_text'),
                    'required' => true,
                ])
            </div>
        </div>

        @include('laravel-cards::partials.buttons-back-submit', [
            'route' => 'jumbotron-images.index'  
        ])

    </form>

@endsection
