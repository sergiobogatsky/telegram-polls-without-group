<template>
    <div class="form-group">
        <div class="container col-4">
            <div id="alerta" hidden="hidden">
                <div class="alert alert-success col-md-offset-1" role="alert">
                    <h4 class="alert-heading">Would you like to send poll?</h4>
                    <p>The action cannot be undone</p>
                    <hr>
                    <div class="btn-group btn-group-justified">
                        <button type="submit" class="btn btn-success btn-block">send</button>
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('alerta').hidden = true;">cancel</button>

                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="card text-center">
                <div class="card-header">
                    <h4>New Poll</h4>
                </div>
                <div class="card-footer text-muted">
                    <button onclick="document.getElementById('alerta').hidden = false;" type="button" class="btn btn-success btn-block">send</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
name: "Index"
}
</script>

<style scoped>

</style>
