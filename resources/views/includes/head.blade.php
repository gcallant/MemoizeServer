<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name') }}</title>

{{--App Icon--}}
<link rel="shortcut icon" href="{{asset('favicon.ico')}}">

{{--Styles--}}
<link rel="stylesheet" href="{{ mix('/css/app.css') }}" />
<script defer src="{{ mix('/js/app.js') }}"></script>
