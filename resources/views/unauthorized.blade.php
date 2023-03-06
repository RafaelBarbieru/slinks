@extends('layouts.app')

@section('content')
<div id="unauthorized-container">
    <div>
        <h1 class="text-center">{{ __('auth.unauthorized') }}</h1>
        <p class="text-center">
            You have tried logging in with the following email: {{ $googleEmail }}, which is not authorized.<br /> Please,
            <a href="https://gmail.com" target="_blank">log out</a> of your current Google account and <a href="{{ url('login') }}">log in</a> with an authorized email.
        </p>
    </div>
</div>
@endsection