<template>
<div>
    <h1>You need to Login to access this site</h1>

    <p>Please provide a valid token</p>
</div>
</template>

<script>
export default {
    created() {
        status = 302;
        window.location = '/login';
    }
}
</script>

<style scoped>

</style>
