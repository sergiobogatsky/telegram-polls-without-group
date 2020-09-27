<template>

    <text-show :response="response" v-if="type == 'text'"></text-show>
    <unique-show :response="response" v-else-if="type == 'unique'"></unique-show>
    <multiple-show :response="response" v-else-if="type == 'multiple'"></multiple-show>
    <sort-show :response="response" v-else-if="type == 'sort'"></sort-show>

</template>

<script>
import TextShow from "./responses/TextShow";
import UniqueShow from "./responses/UniqueShow";
import MultipleShow from "./responses/MultipleShow";
import SortShow from "./responses/SortShow";
export default {
    name: "ResponseShow",
    components: {TextShow, UniqueShow, MultipleShow, SortShow},
    props: {
        response: {},
        type: String,
    }
}
</script>

<style scoped>

</style>
