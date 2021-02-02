<template>
    <div>
        <h1 class="font-normal text-black-100 text-3xl leading-none mb-8">
            Laracasts Stats
        </h1>

        <ul>
            <li><strong>Total Series:</strong> {{ series }}</li>
            <li><strong>Total Lessons:</strong> {{ lessons }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            series: 0,
            lessons: 0,
        };
    },

    created() {
        axios.get('http://127.0.0.1:8081/api/stats').then(response => {
            let {data} = response;

            this.series = data.series;
            this.lessons = data.lessons;
        });
    }
}
</script>

<style scoped>

</style>
