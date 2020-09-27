@extends('layouts/app')

@section('content')
    <div id="poll" class="container">
        <router-view
            :user_id="@if (Auth::check()) {{Auth::user()->id}} @else 1 @endif"

        ></router-view>
    </div>
@endsection
<script src="{{asset('js/polls.js')}}"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
