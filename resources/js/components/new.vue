<template>
    <div>
        <div class="mb-2">
            <ul>
                <li v-for="name in names" v-text="name">ff</li>
            </ul>

            <input v-model="newName">

            <button @click="addName">Add Name</button>
        </div>

        <input :disabled="disabled">

        <button class="button" :title="title" @click="isDisabled">I'm a button</button>
    </div>
</template>

<script>
    export default {
        name: "new",

        data() {
            return {
                newName: '',
                names: ['john', 'jim', 'mary'],
                title: 'Yep- that\'s a button alright.',
                disabled: localStorage.getItem('disabled'),
            };
        },

        watch: {
            toDisable(disabled) {
                if(disabled) {

                }
            }
        },

        methods: {
            addName() {
                this.names.push(this.newName);
                this.newName = '';
            },

            isDisabled() {
                this.disabled = !this.disabled;


                localStorage.setItem('disabled', this.disabled);
            }
        }
    }
</script>

<style scoped>

</style>
