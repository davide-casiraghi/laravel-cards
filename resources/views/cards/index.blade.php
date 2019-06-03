@extends('laravel-cards::cards.layout')

@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h4>Cards list</h4>
        </div>
        <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success create-new" href="{{ route('laravel-cards.create') }}">Add new jumbotron image</a>
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
        @foreach ($cards as $card)
            <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                
                <div class="col-12 py-1">
                    <h5>{{ $card->author }}</h5>
                    <div class="">
                        {{ $card->text }}
                    </div>
                </div>
                
                <div class="col-12 pb-2">
                    <form action="{{ route('laravel-cards.destroy',$card->id) }}" method="POST">
                        <a class="btn btn-primary float-right" href="{{ route('laravel-cards.edit',$card->id) }}">Edit</a>
                        
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-link pl-0">Delete</button>
                    </form>
                </div>
                
            </div>
        @endforeach
        --}}
        
        
        @foreach ($cards as $card)
                <div class="row bg-white shadow-1 rounded mb-3 mx-1">
                    
                    <div class="col-12 pb-2 pt-3 px-3">
                        <div class="row">
                            
                            {{-- Title --}}
                            <div class="col-12 py-1 title">
                                <h5 class="darkest-gray">{{ $card->title }}</h5>
                            </div>
                            <div class="col-12">
                                @if($card->translate('en')->body){{ $card->translate('en')->body }}@endif
                            </div>
                            
                            {{-- Translations --}}
                            <div class="col-12 mb-4 mt-4">
                                @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)
                                    @if($card->hasTranslation($key))
                                        <a href="{{ route('laravel-cards-translation.edit', ['jumbotronImageTranslationId' => $card->id, 'languageCode' => $key]) }}" class="bg-success text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                                    @else
                                        <a href="{{ route('laravel-cards-translation.create', ['jumbotronImageTranslationId' => $card->id, 'languageCode' => $key]) }}" class="bg-secondary text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-12 pb-2 action">
                                <form action="{{ route('laravel-cards.destroy',$card->id) }}" method="POST">

                                    <a class="btn btn-primary float-right" href="{{ route('laravel-cards.edit',$card->id) }}">@lang('views.edit')</a>
                                    <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('laravel-cards.show',$card->id) }}">@lang('views.view')</a>
                                    
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
