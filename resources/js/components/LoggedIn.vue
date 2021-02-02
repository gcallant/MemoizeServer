<template>
<div>
    <h1>You are now logged in!</h1>

    <p>Setting a token into your browser</p>
</div>
</template>

<script>
export default {

    created() {
        window.location = '/logo'
    }
}
</script>

<style scoped>

</style>
