<template>
    <div class="col">
        <div class="row align-items-center">
            <div class="col-sm-1">
                <button type="button" class="btn btn-info"><i class="material-icons md-48">delete</i></button>
            </div>
            <div class="col-sm-10">
                <div class="card border-info mb-3">
                    <div class="card-header">Question</div>
                    <div class="card-body text-info">
                        <div class="row">
                            <div class="col-sm-8">
                                <label for="questions[][text]">Text:</label>
                                <input name="questions[][text]" class="form-control" type="text" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="questions[][type]">Type of response:</label>
                                <select name="questions[][type]" class="form-control">
                                    <option value="unique">unique</option>
                                    <option value="multiple">multiple</option>
                                    <option value="text" selected>text</option>
                                    <option value="sort">sort</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1">
                <button onclick="document.getElementById('poll').appendChild()" type="button" class="btn btn-info align-content-center"><i class="material-icons md-48">add_box</i></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
name: "Question"
}
</script>

<style scoped>

</style>
