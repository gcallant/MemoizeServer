<template>
    <div>
        <h1 class="font-normal text-black-100 text-3xl leading-none mb-8">
            Full Logo
        </h1>

        <div class="mb-10">
            <picture style="height: 382px;" class="block shadow flex items-center justify-center mb-6 rounded-lg">
                <img src="/images/logo.svg" alt="logo"/>
            </picture>

            <div class="flex justify-between items-center">
                <p>
                    Original Logo on <strong>white</strong> background
                </p>

                <a href="/images/logo.svg" class="border rounded-full border-grey-light px-8 py-2 text-black font-bold text-xs">logo.svg</a>
            </div>

        </div>

        <div class="mb-10">
            <picture style="height: 382px;" class="block shadow flex items-center justify-center mb-6 bg-blue rounded-lg">
                <img src="/images/negative-logo.svg" alt="negative-logo"/>
            </picture>

            <div class="flex justify-between items-center">
                <p>
                    Negative Logo on <strong>blue</strong> background
                </p>

                <a href="/images/negative-logo.svg" class="border rounded-full border-grey-light px-8 py-2 text-black font-bold text-xs">negative-logo.svg</a>
            </div>

        </div>

        <div>
            <picture
                style="height: 382px;"
                class="block shadow rounded-lg flex items-center justify-center mb-6 bg-black"
            >
                <img src="/images/pure-negative-logo.svg" alt="logo" />
            </picture>

            <div class="flex justify-between items-center">
                <p>Pure negative logo on <strong>dark</strong> background</p>

                <a
                    href="/images/pure-negative-logo.svg"
                    class="border border-grey-light px-8 py-2 rounded-full text-black font-bold text-xs"
                >pure-negative-logo.svg</a
                >
            </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {};
</script>
