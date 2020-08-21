@extends('layouts.app')

@section('content')
    <form class="vertical-form">
        <div style="margin:0;padding:0;display:inline;">
            <legend>
                Login to Memoize
            </legend>
            @if (Session::has('login_failed'))
                <ul class="notice errors">
                    <li>{{ Session::get('login_failed') }}</li>
                </ul>
            @endif
            @if (Session::has('logout'))
                <ul class="notice success">
                    <li>{{ Session::get('logout') }}</li>
                </ul>
            @endif

            {{--            <button formaction="startLogin" class="createAccount">Login</button>--}}
{{--            <button formaction="startLogin" class="button" >Login</button>--}}

            <a href="startLogin" class="button">Login</a>
            <div id="hostkey" style="width: 100%; visibility: visible">
                <div class="qrcode">

                </div>
                <login-modal></login-modal>
            </div>
        </div>
    </form>
@endsection
