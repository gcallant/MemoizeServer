<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Memoize Assets</title>

    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
</head>
<body class="theme-dark bg-page font-sans mt-4">
<div id="app">
    <header class="py-6 px-8 mb-8" style="background: url('{{asset('images/splash.svg')}}') 0px 2px no-repeat;">
        <h1>
            <img alt="logo" src="{{asset('images/logo.svg')}}"/>
        </h1>
    </header>

    <div class="container px-8 mb-10">

        <main class="flex">
            <aside class="w-64 pt-8">
                <section class="mb-8">
                    <h5 class="uppercase font-bold mb-4 text-base">The Brand</h5>
                    <ul class="list-reset">
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/home" exact>Home</router-link>
                        </li>
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/logo" exact>Logo</router-link>
                        </li>
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/logo-symbol">Logo Symbol</router-link>
                        </li>
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/colors">Colors</router-link>
                        </li>
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/typography">Typography</router-link>
                        </li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h5 class="uppercase font-bold mb-4 text-base">Doodles</h5>
                    <ul class="list-reset">
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/mascot">Mascot</router-link>
                        </li>
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/illustrations">Illustrations</router-link>
                        </li>
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="loaders-and-animations">Loaders & Animations</router-link>
                        </li>
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/wallpapers">Wallpapers</router-link>
                        </li>
                    </ul>
                </section>

                <section class="">
                    <h5 class="uppercase font-bold mb-4 text-base">Stats</h5>
                    <ul class="list-reset">
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/site-stats">Site Stats</router-link>
                        </li>
                    </ul>
                    <ul class="list-reset">
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/achievements">Achievements</router-link>
                        </li>
                        <li class="text-sm pb-4 leading-loose">
                            <router-link class="text-black" to="/logout">Logout</router-link>
                        </li>
                    </ul>
                </section>
            </aside>

            <div class="primary flex-1">
                <router-view></router-view>
            </div>
        </main>


    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
