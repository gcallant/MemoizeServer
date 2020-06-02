<template>
    <modal name="login-modal" classes="p-10 bg-card rounded-lg flex-auto" height="auto">
        <div class="flex-auto pl-2 align-content-center">
        <img src="images/qrcode.png" alt="qrcode"/>
        </div>
    </modal>
</template>

<script>
    import QRCode from 'qrcode';

    QRCode.g
    import BirdboardForm from "./BirdboardForm";
    export default {
        name: "LoginModal",

        data() {
            return {
                form: new BirdboardForm({
                    title: '',

                    description: '',

                    tasks: [
                        {body: ''},
                    ]
                }),
            };
        },

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
