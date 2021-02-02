<template>
    <div>
        <h1 class="font-normal text-3xl text-gray-700 leading-none mb-12">
            Your Achievements
        </h1>

        <ul>
            <li
                v-for="achievement in achievements"
                v-text="achievement"
            ></li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            achievements: [],
            token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiMWFkNGE3MDVmNDNhOTRlYTQ1MDYwMzM1YTRmOWUzZjYyNzJhZWRlZDcwMWU0MzMxNTFkNGYwY2VlMjdmOWIzYTY1MjM5MTA1ZjUyYjAxNTciLCJpYXQiOjE2MTEzNTgwNTksIm5iZiI6MTYxMTM1ODA1OSwiZXhwIjoxNjQyODk0MDU5LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.TDsQZiEqz21uvjQp2KT6M9x9tfgfdxqIfrCuQ95gy6hOBNLyWmETTiMbmGXuUS2tCgCAQbFMC4wz9NYggo86pGPwk8ixquN3NLE-JXiomr8Ska4prrAWu7PgsnL6OqJpWYvlLoD99HE22BKLqP_Do56NK7OHz6R6jKYOcyQrAq_BWVV7BiGtEXs6K9XmFv1MQSUpkUmccf7rYJkadUz5TaqT2Cc_36hVHz2KEzQgrymRm2kbxfd70euO6N5aPYfYKqG4ur4anHAC8iGpooHe4skP9-BWVRpUA5IoJOPeBEwnHrTHzvvxcUjKaHqLQb3eqmN3ARcHTbmK-hC6rEYtBUEhuj40tEl07I-UtbYOXsf2Ra0UhV4YRSAnQ5mYibxmV23OksRPZazfqvCtpk2bXYICbaHKdOahGNhjwDlVy5aCOO-AImaczvqsD_7DAXolvkVbZXwonussXoyil0AsPzcn6PWMd8fObGBZNM67Edd846P598e_g23wcFcUANt5eb18rP-wvmBAhmeCXK0GsTXBIlaIWduBNvP7lo1dgVkx8Vbim2lYxAlOpgsnZYz7ii-WFMezv-3oFx1ANSM2GQ4h0k8Hdsk5bkO4arnjzRVP9ambPwpBgjH8-a8M7oLurJidYzN12E88gFsFeO_-sNn3jMbivReVlDNoDdlPGio'
        };
    },

    created() {
        axios.get('http://127.0.0.1:8081/api/achievements', {
            headers: {
                'Authorization': 'Bearer ' + this.token
            }
        }).then(response => {
            let {data} = response;

            this.achievements.push(data.phone);
            this.achievements.push(data.email);
        })
    }
};
</script>

<style scoped>

</style>
