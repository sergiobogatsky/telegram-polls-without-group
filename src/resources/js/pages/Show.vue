<template>
    <div class="container">
        <div class="card text-center">
            <div class="card-header">
                <h4>{{poll.title}}</h4>
                <p>{{poll.description}}</p>
            </div>
            <div class="card-body">
                <div v-for="question in poll.questions" class="card border-info mb-3">
                    <div class="card-header">
                            <h5 class="text-left">{{ question.text }}</h5>
                        <h6 class="text-right">{{ question.type }}</h6>
                    </div>
                    <div class="card-body text-info">

                            <h4>Responses</h4>


                            <ul class="list-group list-group-flush">
                                <response-show
                                    v-for="(response, index) in question.responses"
                                    :response="response"
                                    :key="index"
                                    :type="question.type"
                                >
                                </response-show>
                            </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ResponseShow from "../components/ResponseShow";
export default {
    name: "Show",
    components: {ResponseShow},
    props: {
        id: Number
    },
    data() {
        return {
            poll: {}
        }
    },
    methods: {
        getPoll: function () {
            //console.log(this.poll)
            this.$http.post('/polls/show/' + this.id, {
                id: this.id
            })
                .then(response => {
                    this.poll = response.data;
                    this.countPercentage()
                })
                .catch(error => {
                    console.log(error);
                });
        },
        countPercentage: function () {
            for (let question of this.poll.questions) {

                for (let response of question.responses) {
                    if (question.type == 'unique') {
                        let votesPerQuestion = 0;
                        for (let questionResponse of question.responses) {
                            votesPerQuestion = votesPerQuestion + questionResponse.total;
                        }
                        if (votesPerQuestion != 0) {
                            response.percent = Math.round((response.total / (votesPerQuestion / 100) * 100)) / 100;
                        }
                        else {
                            response.percent = 0.00;
                        }
                    }
                    else if (question.type == 'multiple') {
                        if (question.clients.length == response.total) {
                            response.percent = 100;
                        }
                        else {
                            response.percent = Math.round((response.total / (question.clients.length / 100) * 100)) / 100;
                        }
                    }
                    else if (question.type == 'sort') {
                        response.options = [];

                        for (let i = 1; i <= question.responses.length; i++) {
                            let array = response.clients.filter(
                                function (client) {
                                    return client.pivot.sort_position == i
                                }
                            )
                            if (array.length == 0) {
                                response.options.push({position: i, percent: 0});
                            }
                            else  {
                                response.options.push({position: i, percent: Math.round(array.length / (question.clients.length / 100)* 100) / 100});
                            }
                        }
                    }
                }
            }
        }
    },
    mounted() {
        this.getPoll()
    }
}
</script>

<style scoped>

</style>
