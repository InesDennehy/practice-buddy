<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card category border-0 shadow">
                    <div class="card-header modal-header category-header">
                        <h3 class="card-title m-0 font-weight-light">Overview</h3>
                    </div>
                    <div class="card-body">
                        <h4>Average pieces studied per day: {{avgPiecesPD}}</h4>
                        <Line-Chart :chart-data="times_per_day_data"
                            :options="{
                                scales: {
                                    xAxes: [{
                                        ticks: {
                                            beginAtZero: true,
                                        },
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
                            :options="{
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
                                        beginAtZero: true,
                                        max: 7,
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
                            }">
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
            this.getData();
        },
        props:{
            all_pieces:{
                type: Array,
                required: true,
            }
        },
        data(){
            return{
                data: [],
                days: [],
                avgPiecesPD: 0,
                pieces: [],
                times_per_piece_data: {},
                times_per_day_data: {},
            }
        },
        methods: {
            getData: function(){
                axios.get("/stats/week").then((response) =>{
                    this.data = response.data.data;
                    this.days = response.data.days;
                    localStorage.stats_data = JSON.stringify(this.data);
                    localStorage.days = JSON.stringify(this.days);
                    this.pieces = [...new Set(this.data.map(session => session.piece_name))];
                    this.updateTimesPerPieceData();
                    this.updateTimesPerDayData();
                });
            },
            updateTimesPerPieceData: function(){
                this.avgPiecesPD = this.data.length/this.days.length;
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
            }
        }
    }
</script>
