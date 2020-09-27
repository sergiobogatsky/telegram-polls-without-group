<template>
        <div class="container">
            <div class="card text-center">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h2 class="text-primary">Polls</h2>
                        </div>
                        <div class="col-sm-4">
                            <router-link :to="{name: 'Create'}">create</router-link>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive" id="search-users-result">
                    <table class="table table-bordered" id="MyTable">
                        <thead>
                        <tr>
                            <th class="text-center">title</th>
                            <th class="text-center">description</th>
                            <th class="text-center">created</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="poll in paginatedData" :key="poll.id">

                            <td class="text-center">{{poll.title}}</td>
                            <td class="text-center">{{ poll.description }}</td>
                            <td class="text-center">{{ poll.created_at }}</td>
                            <td class="text-center"><router-link :to="{path: '/polls/show/'+ poll.id}">show</router-link></td>

                        </tr>

                        </tbody>
                    </table>
                    <div class="card-footer d-flex">
                        <div class="mx-auto users-pagination">
                            <nav aria-label="Page navigation example">
                                <paginate
                                    :page-count="Math.ceil(polls.length / itemsPerPage)"
                                    :page-range="3"
                                    :margin-pages="2"
                                    :click-handler="nextPage"
                                    :prev-text="'Prev'"
                                    :next-text="'Next'"
                                    :page-class="'page-item'"
                                    :container-class="'pagination'"
                                    :page-link-class="'page-link'"
                                    :prev-link-class="'page-link'"
                                    :next-link-class="'page-link'"
                                >
                                </paginate>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    name: "Index",

    data() {
        return {
            polls: [],
            pageNumber: 0,
            itemsPerPage: 10
        }
    },
    methods: {
        getPolls: function () {
            this.$http.post('/polls', {
                user_id: 1//after it has to be real id
            },{withCredentials: true})
                .then(response => {
                    this.polls = response.data
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);

                });
        },
        nextPage: function (pageNum) {
            this.pageNumber = pageNum - 1;
        },
    },
    mounted() {
        this.getPolls()

    },
    computed: {
        paginatedData(){
            const start = this.pageNumber * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.polls.slice(start, end);
        }
    }
}
</script>

<style scoped>
.pagination {
}
.page-item {
}
</style>
