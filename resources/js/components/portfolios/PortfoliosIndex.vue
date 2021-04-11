<template>
    <div>
        <h2>Portfolios</h2>

        <div class="row py-2">
            <div class="col-lg-12">
                <div class="card">
                </div>
            </div>
            <div v-for="(portfolio, index) in portfolios" class="col-lg-12">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ portfolio.title }}</h3>
                        </div>
                        <div class="card-body">
                            <div>{{ portfolio.sum }}</div>
                            <div>{{ portfolio.currency }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import 'axios';

    export default {
        name: "monitoring-s2s",
        props: [],
        data() {

            return {

                portfolios: [],

            }

        },
        mounted() {

            this.getList();

        },

        methods: {

            getList: function (filters) {

                url = '/api/portfolios';

                if(filters !== null){
                    url += url + '?' + filters;
                }

                axios
                    .get(url)
                    .then(response => {
                        this.portfolios = response.data;
                    })
                    .catch(error => {
                        console.log(url);
                        console.log(error);
                    })
                    .finally(() => {

                    });

            },
        },
    }

</script>
