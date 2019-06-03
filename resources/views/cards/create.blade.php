@extends('laravel-cards::cards.layout')

@section('content')

    <div class="container mb-4">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Add new card</h4>
                </div>
            </div>

            @include('laravel-form-partials::error-management', [
                  'style' => 'alert-danger',
            ])

            <form action="{{ route('laravel-cards.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    {{-- Heading  --}}
                    <div class="col-12">
                        @include('laravel-form-partials::input', [
                            'title' => 'Heading',
                            'name' => 'heading',
                            'placeholder' => '', 
                            'value' => old('heading'),
                            'required' => true,
                        ])
                    </div>
                    
                    {{-- Title  --}}
                    <div class="col-12">
                        @include('laravel-form-partials::input', [
                            'title' => 'Title',
                            'name' => 'title',
                            'placeholder' => '', 
                            'value' => old('title'),
                            'required' => true,
                        ])
                    </div>
    
                    {{-- Body --}}
                    <div class="col-12">
                        @include('laravel-form-partials::textarea-plain', [
                            'title' => 'Body',
                            'name' => 'body',
                            'value' => old('body'),
                            'required' => false,
                        ])
                    </div>

                    {{-- Image --}}
                    @include('laravel-form-partials::upload-image', [
                          'title' => 'Jumbotron background image', 
                          'name' => 'image_file_name',
                          'folder' => 'cards',
                          'value' => '',
                          'required' => false,
                    ])
                    
                    {{-- Jumbotron Height --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Jumbotron Height",
                              'name' => 'jumbotron_height',
                              'placeholder' => "choose one...", 
                              'records' => $jumbotronHeightArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('jumbotron_height'),
                              'required' => true,
                              'tooltip' => 'The height is expressed in Bulma size unit like, check Bulma website.',
                        ])
                    </div>
                    
                    {{-- Background color --}}
                    <div class="col-12">
                        @include('laravel-form-partials::input', [
                            'title' =>  'Background color',
                            'name' => 'background_color',
                            'tooltip' => 'Exadecimal value for the background color. Active if a value is specified.',
                            'placeholder' => '#HEX', 
                            'value' => old('background_color'),
                            'required' => false,
                        ])
                    </div>
                    
                    {{-- Cover Opacity --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Cover Opacity",
                              'name' => 'cover_opacity',
                              'placeholder' => "choose one...", 
                              'records' => $coverOpacityArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('cover_opacity'),
                              'required' => true,
                              'tooltip' => 'Add an opaque layer above the background image'
                        ])
                    </div>
                    
                    {{-- ====================================================== --}}
                    
                    <div class="col-12">
                        <hr>
                        <h4 class="mt-4 mb-4">Text options</h4>
                    </div>
                    
                    {{-- Text width --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Width",
                              'name' => 'text_width',
                              'placeholder' => "choose one...", 
                              'records' => $textWidthArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('text_width'),
                              'tooltip' => 'Just for the desktop view.',
                              'required' => false,
                        ])
                    </div>
                    
                    {{-- Text vertical alignment --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Vertical alignment",
                              'name' => 'text_vertical_alignment',
                              'placeholder' => "choose one...", 
                              'records' => $textVerticalAlignmentArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('text_vertical_alignment'),
                              'required' => false,
                        ])
                    </div>
                    
                    {{-- Text vertical alignment --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Hotizontal alignment",
                              'name' => 'text_horizontal_alignment',
                              'placeholder' => "choose one...", 
                              'records' => $textHorizontalAlignmentArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('text_horizontal_alignment'),
                              'required' => false,
                        ])
                    </div>
                    
                    {{-- Text shadow  --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Shadow",
                              'name' => 'text_shadow',
                              'placeholder' => "choose one...", 
                              'records' => $textShadowArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('text_shadow'),
                              'required' => false,
                        ])
                    </div>
                    
                    {{-- ====================================================== --}}
                    
                    <div class="col-12">
                        <hr>
                        <h4 class="mt-4 mb-4">Button options</h4>
                    </div>
                    
                    {{-- Button url --}}
                    <div class="col-12">
                        @include('laravel-form-partials::input', [
                            'title' =>  'Button url',
                            'name' => 'button_url',
                            'placeholder' => 'https://...', 
                            'value' => old('button_url'),
                            'required' => false,
                        ])
                    </div>
                    
                    {{-- Button text --}}
                    <div class="col-12">
                        @include('laravel-form-partials::input', [
                            'title' =>  'Button text',
                            'name' => 'button_text',
                            'placeholder' => '', 
                            'value' => old('button_text'),
                            'required' => false,
                        ])
                    </div>
                    
                    {{-- Button color --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Button color",
                              'name' => 'button_color',
                              'placeholder' => "choose one...", 
                              'records' => $buttonColorArray,
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => old('button_color'),
                              'tooltip' => 'Check the press-css.io website for the preview of the color available.',
                              'required' => false,
                        ])
                    </div>
                    
                    <div class="col-12">
                        <hr>
                        <h4 class="mt-4 mb-4">Extra options</h4>
                    </div>
                    
                    <div class="col-12">
                        @include('laravel-form-partials::checkbox', [
                              'name' => 'scroll_down_arrow',
                              'description' => 'Show scroll down arrow',
                              'value' => old('scroll_down_arrow'),
                              'required' => false,
                        ])
                    </div>
                    
                    <div class="col-12">
                        @include('laravel-form-partials::checkbox', [
                              'name' => 'parallax',
                              'description' => 'Parallax effect for the background image',
                              'value' => old('parallax'),
                              'required' => false,
                        ])
                    </div>
                    
                    {{-- White moon --}}
                    <div class="col-12">
                        @include('laravel-form-partials::checkbox', [
                              'name' => 'white_moon',
                              'description' => 'White moon under the banner',
                              'value' => old('white_moon'),
                              'required' => false,
                        ])
                    </div>
                                        
                    <div class="col-12">
                        @include('laravel-form-partials::buttons-back-submit', [
                           'route' => 'laravel-cards.index'  
                       ])
                    </div>
                                
                </div>
            </form>
    
    </div>
    
@endsection
