<template>
    <li class="list-group-item">
        <h5>{{response.text}}</h5>
        {{'Total votes: ' + response.total}}
        <div class="row"
             v-for="(option, index) in response.options"
        >
            <div class="col-1">{{option.position}}</div>
            <div class="col-11">
                <div class="progress">
                    <div
                        class="progress-bar"
                        role="progressbar"
                        :style="'width: ' + option.percent + '%;'"
                        :aria-valuenow="option.percent"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    >
                        {{option.percent}}%
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    name: "SortShow",
    props: {
        response: {},
    },
}
</script>

<style scoped>

</style>
