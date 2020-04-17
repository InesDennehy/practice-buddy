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

                <div class="card category border-0 shadow">
                    <div class="card-header modal-header category-header">
                        <h3 class="card-title m-0 font-weight-light">Overview</h3>
                    </div>
                    <div class="card-body">
                        <h4>Average pieces studied per day: {{avgPiecesPD}}</h4>
                        <Line-Chart :chart-data="times_per_day_data"
                            :options="{
                                respinsive:true,
                                mantainAspectRatio: false,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            max: all_pieces.length,
                                        }
                                    }]
                                }
                            }">
                        </Line-Chart>
                    </div>
                </div>

                <div class="card category border-0 shadow">
                    <div class="card-header modal-header category-header">
                        <h3 class="card-title m-0 font-weight-light">Times Studied per piece</h3>
                    </div>
                    <div class="card-body">
                        <Radar-Chart :chart-data="times_per_piece_data"
                            :options="times_per_piece_options">
                        </Radar-Chart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Chart from 'chart.js';
    import axios from 'axios';

    export default {
        mounted() {
            if(this.existent_pieces){
                this.getData(7);
            }
        },
        props:{
            all_pieces:{
                type: Array,
                required: true,
            }
        },
        data(){
            return{
                existent_pieces: this.all_pieces.length != [],
                data: [],
                days: [],
                period: 'last week',
                avgPiecesPD: 0,
                pieces: [],
                times_per_piece_data: {},
                times_per_piece_options: {},
                times_per_day_data: {},
            }
        },
        methods: {
            getData: function(number){
                axios.get("/stats/last/"+number).then((response) =>{
                    this.data = response.data.data;
                    this.days = response.data.days;
                    this.pieces = [...new Set(this.data.map(session => session.piece_name))];
                    this.times_per_piece_options = {
                    scale: {
                        pointLabels: {
                            callback: function(pointLabel) {
                                if (pointLabel.length > 10) {
                                    return pointLabel.substr(0, 10) + '...'; //truncate
                                } else {
                                    return pointLabel
                                }
                            }
                        },
                        ticks: {
                            max: this.days.length,
                            min: -1,
                        }
                    },
                    tooltips: {
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return data.labels[tooltipItems.index];
                            }
                        }
                    },
                }

                    this.updateTimesPerPieceData();
                    this.updateTimesPerDayData();
                });
            },
            updateTimesPerPieceData: function(){
                this.times_per_piece_data = {
                    labels: this.all_pieces,
                    datasets: [{
                        label: 'times studied',
                        data: this.getTimesPlayed(),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                }
            },
            updateTimesPerDayData: function(){
                this.avgPiecesPD = this.data.length/this.days.length;
                var data_days_count = [];
                this.days.forEach(date => {
                    var count = this.data.reduce((n, session) => n + (session.created_at == date), 0);
                    data_days_count.push(count);
                });

                this.times_per_day_data = {
                    labels: this.days,
                    datasets: [{
                        label: 'number of pieces studied',
                        data: data_days_count,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                }
            },

            getTimesPlayed: function(){
                var piece_times_count = [];
                this.all_pieces.forEach(piece =>{
                    var count = this.data.reduce((n, session) => n + (session.piece_name == piece), 0);
                    piece_times_count.push(count);
                });
                return piece_times_count;
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
