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

            <div v-if="existent_pieces" class="col-md-8"  style="max-width: 600px;">

                <per-time-panel v-bind:time_range="days"
                    v-bind:max_pieces="pieces_data.length"
                    v-bind:data="data"
                    @change-left="changeDataLeft()"
                    @change-right="changeDataRight()"></per-time-panel>

                <per-category-panel v-bind:data="data"
                    v-bind:categories="all_categories"></per-category-panel>

                <per-piece-panel v-bind:data="data"
                    v-bind:categories="all_categories"
                    v-bind:pieces="pieces_data"
                    v-bind:max_number="days.length"></per-piece-panel>
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
                offset: 0,
                pieces_data: [],
                all_categories: [],
            }
        },
        methods: {
            getAllPiecesData: function(){
                axios.get("/pieces/all").then((response) =>{
                    this.pieces_data = response.data.pieces;
                    this.all_categories = response.data.categories;
                    this.existent_pieces = this.pieces_data.length != [];
                    if(this.existent_pieces){
                        this.getData(7);
                    }
                })
            },
            getData: function(number){
                axios.get("/stats", {params: {days: number, offset: this.offset}}).then((response) =>{
                    this.data = response.data.data;
                    this.days = response.data.days;
                    this.pieces = [...new Set(this.data.map(session => session.piece_name))];
                });
            },

            changeDataLeft: function(){
                this.offset--;
                this.getData(7);
                return;
            },
            changeDataRight: function(){
                this.offset++;
                this.getData(7);
                return;
            }
        }
    }
</script>
