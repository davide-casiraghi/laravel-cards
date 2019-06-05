@extends('laravel-cards::cards.layout')

@section('content')

    <div class="container mb-4">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Edit card</h4>
                </div>
            </div>

            @include('laravel-form-partials::error-management', [
                  'style' => 'alert-danger',
            ])

            <form action="{{ route('laravel-cards.update', $card->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    {{-- Heading  --}}
                    <div class="col-12">
                        @include('laravel-form-partials::input', [
                            'title' => 'Heading',
                            'name' => 'heading',
                            'placeholder' => '', 
                            'value' => $card->heading,
                            'required' => true,
                        ])
                    </div>
                    
                    {{-- Title  --}}
                    <div class="col-12">
                        @include('laravel-form-partials::input', [
                            'title' => 'Title',
                            'name' => 'title',
                            'placeholder' => '', 
                            'value' => $card->title
                        ])
                    </div>
                    
                    {{-- Body --}}
                    <div class="col-12">
                        @include('laravel-form-partials::textarea-plain', [
                            'title' =>  'Body',
                            'name' => 'body',
                            'value' => $card->body
                        ])
                    </div>
                    
                    {{-- Image --}}
                    @include('laravel-form-partials::upload-image', [
                          'title' => 'Card image',
                          'name' => 'image_file_name',
                          'folder' => 'cards',
                          'value' => $card->image_file_name
                    ])
                    
                    {{-- Image Alignment --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Image Alignment",
                              'name' => 'img_alignment',
                              'placeholder' => "choose one...", 
                              'records' => [
                                 '1' => 'Left',
                                 '2' => 'Right',
                              ],
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => $card->img_alignment,
                              'required' => false,
                              'tooltip' => 'aaa',
                        ])
                    </div>
                    
                    {{-- Image column size --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Image column size",
                              'name' => 'img_col_size',
                              'placeholder' => "choose one...", 
                              'records' => [
                                 '1' => '200px',
                                 '2' => '300px',
                                 '2' => '400px',
                              ],
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => $card->img_col_size,
                              'required' => false,
                              'tooltip' => 'aaa',
                        ])
                    </div>
                    
                    {{-- Background color --}}
                    <div class="col-12">
                        @include('laravel-form-partials::input', [
                            'title' =>  'Background color',
                            'name' => 'bkg_color',
                            'tooltip' => 'Exadecimal value for the background color. Active if a value is specified.',
                            'placeholder' => '#HEX', 
                            'value' => $card->bkg_color,
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
                            'value' => $card->button_url
                        ])
                    </div>
                    
                    {{-- Button text --}}
                    <div class="col-12">
                        @include('laravel-form-partials::input', [
                            'title' =>  'Button text',
                            'name' => 'button_text',
                            'placeholder' => '', 
                            'value' => $card->button_text
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
                              'seleted' => $card->button_color,
                              'required' => true,
                              'tooltip' => 'Check the press-css.io website for the preview of the color available.',
                              'required' => false,
                        ])
                    </div>
                    
                    {{-- Button Corners --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Button Corners",
                              'name' => 'button_corners',
                              'placeholder' => "choose one...", 
                              'records' => [
                                 '1' => 'Square',
                                 '2' => 'Half Round',
                                 '3' => 'Round',
                              ],
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => $card->button_corners,
                              'required' => false,
                              'tooltip' => 'aaa',
                        ])
                    </div>
                    
                    {{-- Button Icon --}}
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => "Button Icon",
                              'name' => 'button_icon',
                              'placeholder' => "choose one...", 
                              'records' => [
                                 '1' => 'None',
                                 '2' => 'Arrow right',
                                 '3' => 'Arrow down',
                              ],
                              'liveSearch' => 'false',
                              'mobileNativeMenu' => true,
                              'seleted' => $card->button_icon,
                              'required' => false,
                        ])
                    </div>
                        
                    <div class="col-12">
                        <hr>
                        <h4 class="mt-4 mb-4">Extra options</h4>
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
