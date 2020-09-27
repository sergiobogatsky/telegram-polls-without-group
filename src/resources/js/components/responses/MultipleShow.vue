<template>
    <li class="list-group-item">
        <h5>{{response.text}}</h5>
        {{'Total votes: ' + response.total}}
        <div class="progress">
            <div
                class="progress-bar"
                role="progressbar"
                :style="'width: ' + response.percent + '%;'"
                :aria-valuenow="response.percent"
                aria-valuemin="0"
                aria-valuemax="100"
            >
                {{response.percent}}%
            </div>
        </div>
    </li>
</template>

<script>
export default {
    name: "MultipleShow",
    props: {
        response: {},
    }
}
</script>

<style scoped>

</style>
