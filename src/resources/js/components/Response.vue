<template>
    <div class="col">
        <h3>
            <span class="badge badge-pill badge-primary">
                {{response.text}}
                <button
                    v-if="type != 'text'"
                    v-on:click="$emit('removeResponse', index)"
                    type="button"
                    class="btn btn-sm"
                >
                    <i class="material-icons md-18">clear</i>
                </button>
            </span>
        </h3>
    </div>
</template>

<script>
export default {
    name: "Response",
    props: {
        response: {},
        index: Number,
        type: String,
    },
}
</script>

<style scoped>

</style>
