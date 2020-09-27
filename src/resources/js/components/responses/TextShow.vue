<template>
    <li class="list-group-item">
        <h5>{{response.text}}</h5>
    </li>
</template>

<script>
export default {
    name: "TextShow",
    props: {
        response: {},
    }
}
</script>

<style scoped>

</style>
