<template>
    <div class="col">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <div class="card border-info mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-2">
                                <button v-if="length > 1" v-on:click="$emit('removeQuestion', index)" type="button" class="btn btn-info"><i class="material-icons md-48">delete</i></button>
                            </div>
                            <div class="col">
                                <h4>Question</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-info">
                        <div class="row">
                            <div class="col-sm-8">
                                <label>Text:</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    v-model="question.text"
                                    v-on:input="$emit('modifyQuestion', question, index)"
                                >
                            </div>
                            <div class="col-sm-4">
                                <label>Type of response:</label>
                                <select
                                    v-model="question.type"
                                    class="form-control"
                                    v-on:change="responseControl(); $emit('modifyQuestion', question, index);"
                                >
                                    <option value="unique">unique</option>
                                    <option value="multiple">multiple</option>
                                    <option value="text" selected>text</option>
                                    <option value="sort">sort</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12" v-if="this.question.type != 'text'">
                            <h4>Responses</h4>
                        </div>
                        <div class="row">
                            <response
                                v-for="(response, index) in question.responses"
                                :key="index"
                                :response="response"
                                :index="index"
                                :type="question.type"
                                @removeResponse="removeResponse"
                            >

                            </response>
                            <div class="col-sm-3">
                                <input
                                    v-model="newResponseText"
                                    v-if="this.question.type != 'text'"
                                    class="form-control"
                                    type="text"
                                >
                            </div>
                            <div class="col-sm-1">
                                <button
                                    v-if="this.question.type != 'text'"
                                    v-on:click="addNewResponse"
                                    type="button"
                                    class="btn btn-info align-content-center">
                                    <i class="material-icons md-48">add_box</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Response from "./Response";
export default {
    name: "Question",
    components: {Response},
    props: {
        question: {},
        index: Number,
        length: Number,
    },
    data()  {
        return {
            newResponseText: ''
        }
    },
    methods: {
        addNewResponse: function () {
            if (this.newResponseText.length > 0) {
                this.question.responses.push({
                    text: this.newResponseText,
                    callback_data: 'callback_data_' + this.newResponseText
                })
                this.newResponseText = ''
            }
        },
        removeResponse: function (index) {
            for (let i = 0; i < this.question.responses.length; i++) {
                if (i == index) {
                    this.question.responses.splice(index, 1);
                    this.$emit('modifyQuestion', this.question, this.index)
                }
            }
        },
        responseControl: function () {
            if (this.question.type == 'text') {
                this.question.responses = [];
            }
        },
    }
}
</script>

<style scoped>

</style>
