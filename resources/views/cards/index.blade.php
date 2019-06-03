@extends('laravel-cards::jumbotronImages.layout')

@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h4>Jumbotron images list</h4>
        </div>
        <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success create-new" href="{{ route('jumbotron-images.create') }}">Add new jumbotron image</a>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    
    {{-- List all the quotes --}}
    <div class="quotesList my-4">
        
        {{--
        @foreach ($jumbotronImages as $jumbotronImage)
            <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                
                <div class="col-12 py-1">
                    <h5>{{ $jumbotronImage->author }}</h5>
                    <div class="">
                        {{ $jumbotronImage->text }}
                    </div>
                </div>
                
                <div class="col-12 pb-2">
                    <form action="{{ route('jumbotron-images.destroy',$jumbotronImage->id) }}" method="POST">
                        <a class="btn btn-primary float-right" href="{{ route('jumbotron-images.edit',$jumbotronImage->id) }}">Edit</a>
                        
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-link pl-0">Delete</button>
                    </form>
                </div>
                
            </div>
        @endforeach
        --}}
        
        
        @foreach ($jumbotronImages as $jumbotronImage)
                <div class="row bg-white shadow-1 rounded mb-3 mx-1">
                    
                    <div class="col-12 pb-2 pt-3 px-3">
                        <div class="row">
                            
                            {{-- Title --}}
                            <div class="col-12 py-1 title">
                                <h5 class="darkest-gray">{{ $jumbotronImage->title }}</h5>
                            </div>
                            <div class="col-12">
                                @if($jumbotronImage->translate('en')->body){{ $jumbotronImage->translate('en')->body }}@endif
                            </div>
                            
                            {{-- Translations --}}
                            <div class="col-12 mb-4 mt-4">
                                @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)
                                    @if($jumbotronImage->hasTranslation($key))
                                        <a href="{{ route('jumbotron-images-translation.edit', ['jumbotronImageTranslationId' => $jumbotronImage->id, 'languageCode' => $key]) }}" class="bg-success text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                                    @else
                                        <a href="{{ route('jumbotron-images-translation.create', ['jumbotronImageTranslationId' => $jumbotronImage->id, 'languageCode' => $key]) }}" class="bg-secondary text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-12 pb-2 action">
                                <form action="{{ route('jumbotron-images.destroy',$jumbotronImage->id) }}" method="POST">

                                    <a class="btn btn-primary float-right" href="{{ route('jumbotron-images.edit',$jumbotronImage->id) }}">@lang('views.edit')</a>
                                    <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('jumbotron-images.show',$jumbotronImage->id) }}">@lang('views.view')</a>
                                    
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>    
            @endforeach    
        
        
        
                      
    </div>

@endsection
