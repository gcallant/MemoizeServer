<template>

</template>

<script>

// Enable pusher logging - don't include this in production


Pusher.logToConsole = true;

export default {
    name: "LoginModal",


    methods: {
        addTask() {
            this.form.tasks.push({body: ''});
        },

        async submit() {
            if (!this.form.tasks[0].body) {
                delete this.form.originalData.tasks;
            }

            this.form.submit('/projects')
                .then(response => location = response.data.message);
            // try {
            //     location = (await axios.post('/projects', this.form)).data.message;
            // } catch (error) {
            //     this.errors = error.response.data.errors;
            // }
        }
    }
}
</script>

<style scoped>

</style>
