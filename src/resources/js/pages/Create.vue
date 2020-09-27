<template>
    <div class="form-group">
        <div class="container col-4">
            <div id="alerta" hidden="hidden">
                <div class="alert alert-success col-md-offset-1" role="alert">
                    <h4 class="alert-heading">Would you like to send poll?</h4>
                    <p>The action cannot be undone</p>
                    <hr>
                    <div class="btn-group btn-group-justified">
                        <button type="button" v-on:click="storeAndSendPoll" class="btn btn-success btn-block">send</button>
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('alerta').hidden = true;">cancel</button>

                    </div>

                </div>
            </div>
        </div>
        <div
            v-for="(index, error) in errors"
            :key="error.index"
            class="toast"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-delay="4000"
        >
            <div class="toast-header">
                <img src="" class="rounded mr-2" alt="">
                <strong class="mr-auto">Bootstrap</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                {{index[0]}}
            </div>
        </div>


        <div class="container">
            <div class="card text-center">
                <div class="card-header">
                    <h4>New Poll</h4>
                </div>
                <poll
                    :user_id="user_id"
                    @createPoll="createPoll"
                >
                </poll>
                <div class="card-footer text-muted">
                    <button onclick="document.getElementById('alerta').hidden = false;" type="button" class="btn btn-success btn-block">send</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Poll from "../components/Poll";

export default {
    name: "Create",
    components: {Poll},
    props: {
        user_id: Number,
    },
    data() {
        return {
            poll: {},
            errors: {}
        }
    },
    methods: {
        createPoll: function (poll) {
            this.poll = poll;
        },
        storeAndSendPoll: function () {
            this.$http.post('/polls/store', {
                poll: this.poll
            })
                .then(response => {
                    console.log(response.data);
                    this.$router.push('/polls/show/' + response.data.id);
                })
                .catch(error => {
                    if (error.response) {
                        document.getElementById('alerta').hidden = true;
                        this.errors = error.response.data.errors
                    }
                });
        }
    },
    updated() {
        $('.toast').toast('show');
    }
}
</script>

<style scoped>

</style>
