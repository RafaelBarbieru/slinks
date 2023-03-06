@extends('layouts.app')

@include('partials.hide_scrollbar')
@include('partials.app_title')

@section('content')

<div class="slinks-100vh slinks-hv-center">
    <div class="card" style="width: 18rem;">
        <!--<img class="card-img-top" src="{{ URL::asset('img/image.svg') }}" alt="Card image cap">-->
        <div class="card-body">
            <h5 class="card-title">{{ __('auth.login_headline') }}</h5>
            <p class="card-text">{{ __('auth.sign_in_with_google') }}</p>
            <a href="{{ route('redirect') }}" class="btn btn-slinks">{{ __('auth.sign_in_with_google_btn') }}</a>
        </div>
    </div>
</div>
@endsection