<template>
    <div>
        <h1 class="font-normal text-black-100 text-3xl leading-none mb-8"
        >You are being logged out</h1>
    </div>
</template>

<script>
export default {
    async created() {
        await axios.post('/api/logout')
        await localStorage.removeItem('memoizeToken');
        status = 302;
        window.location = '/logout';
    }
}
</script>

<style scoped>

</style>
