<template>
    <div class="container">
        <form>
            <div class="form-group">
                <label for="title">Title</label>
                <input v-on:input="$emit('createPoll', poll)" v-model="poll.title" id="title" type="text" class="form-control" placeholder="title">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input v-on:input="$emit('createPoll', poll)" v-model="poll.description" type="text" class="form-control" id="description" placeholder="description">
            </div>
            <question
                v-for="(question, index) in poll.questions"
                :key="index"
                :question="question"
                :index="index"
                :length="poll.questions.length"
                @modifyQuestion="modifyQuestion"
                @removeQuestion="removeQuestion"
            >
            </question>
            <div class="col-sm-1">
                <button
                    v-on:click="addNewQuestion"
                    type="button"
                    class="btn btn-info align-content-center">
                    <i class="material-icons md-48">add_box</i>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import Question from "./Question";
export default {
    name: "Poll",
    props: {
        user_id: Number,
    },
    components: {Question},
    data() {
        return {
            poll: {
                user_id: this.user_id,
                title: '',
                description: '',
                questions: [
                    {
                        text: '',
                        type: 'text',
                        responses: []
                    }
                ],
            }
        }
    },
    methods: {
        addNewQuestion: function () {
            this.poll.questions.push({
                text: '',
                type: 'text',
                responses: []
            })
        },
        removeQuestion: function (index) {
            this.poll.questions.splice(index, 1);
        },
        modifyQuestion: function (newQuestion, index) {
            for (let i = 0; i < this.poll.questions.length; i++) {
                if (i == index) {
                    this.poll.questions[i] = newQuestion
                    this.$emit('createPoll', this.poll)
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
