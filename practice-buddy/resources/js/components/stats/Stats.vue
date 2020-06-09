<template>
    <div class="container">
        <div class="row justify-content-center">
            <div v-if="!existent_pieces" class="col-md-8">
                <div class="card category border-0 shadow">
                    <img class="card-img-top no-pieces-filler" src="images/no-pieces-filler.png" alt="Image">
                    <div class="card-body">
                        <div class="card-title">
                            <h4 class="display text-center">There are currently no pieces added, try and add one!</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="existent_pieces" class="col-md-8">
                <div class="card category border-0 shadow">
                    <div class="card-body">
                        <div class="card-title">
                            <h4 class="display text-center">Showing data from</h4>
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link" v-bind:class="{ active: period == 'last week' }" href="#"
                                        @click="activateLastWeek">Last week</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" v-bind:class="{ active: period == 'last month' }" href="#"
                                        @click="activateLastMonth">Last month</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" v-bind:class="{ active: period == 'last year' }" href="#"
                                        @click="activateLastYear">Last year</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

                <per-time-panel v-bind:time_range="days"
                    v-bind:max_pieces="all_pieces.length"
                    v-bind:group="group"
                    v-bind:data="data"></per-time-panel>

                <per-category-panel v-bind:data="data"
                    v-bind:categories="all_categories"></per-category-panel>

                <per-piece-panel v-bind:data="data"
                    v-bind:categories="all_categories"
                    v-bind:pieces="all_pieces"></per-piece-panel>
            </div>
        </div>
    </div>
</template>

<script>
    import Chart from 'chart.js';
    import axios from 'axios';

    export default {
        mounted() {
            this.getAllPiecesData();
        },
        data(){
            return{
                existent_pieces: true,
                data: [],
                days: [],
                all_pieces: [],
                all_categories: [],
                group: 'day',
                period: 'last week',
            }
        },
        methods: {
            getAllPiecesData: function(){
                axios.get("/pieces/all").then((response) =>{
                    this.all_pieces = response.data.pieces;
                    this.all_categories = response.data.categories;
                    this.existent_pieces = this.all_pieces.length != [];
                    if(this.existent_pieces){
                        this.getData(7);
                    }
                })
            },
            getData: function(number){
                axios.get("/stats/last/"+number).then((response) =>{
                    this.data = response.data.data;
                    this.days = response.data.days;
                    this.pieces = [...new Set(this.data.map(session => session.piece_name))];
                });
            },

            activateLastWeek: function(event){
                event.preventDefault();
                if(this.period != 'last week'){
                    this.getData(7);
                    this.period = 'last week';
                }
            },
            activateLastMonth: function(event){
                event.preventDefault();
                if(this.period != 'last month'){
                    this.getData(30);
                    this.period = 'last month';
                }
            },
            activateLastYear: function(event){
                event.preventDefault();
                if(this.period != 'last year'){
                    this.getData(365);
                    this.period = 'last year';
                }
            },
        }
    }
</script>
