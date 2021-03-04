<template>
    <div>
        <h1 class="font-normal text-black-100 text-3xl leading-none mb-8"
        >Hi {{name}} you are logged in!</h1>
        <p>Here are your current details:</p>
        <p>Your registered eMail: {{ email }}</p>
        <p>Your registered phone number: {{ phone }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            phone: '',
        };
    },

    async created() {
        let response = await axios.get('/api/isUser');
        let {data} = response;

        this.name = data.name;
        this.phone = data.phone;
        this.email = data.email;
    },
}
</script>

<style scoped>

</style>
