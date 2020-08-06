<template>
    <div class="card category border-0 shadow" >
        <div class="card-header modal-header category-header">
            <h3 class="card-title m-0 font-weight-light">Times Studied per piece</h3>
        </div>
        <div class="card-body">
            <h4>Max: {{max.count}} ({{max.piece}})</h4>
            <h4>Min: {{min.count}} ({{min.piece}})</h4>
            <h4>Avg: {{avg}}</h4>
            <div id="carouselExampleControls"
                class="carousel slide"
                data-ride="carousel"
                data-interval="false">

                <div class="carousel-inner">
                    <div v-for="(category, index) in categories"
                        :key="index" class="carousel-item"
                        :class="{active: index == 0}">
                        <h4 class="text-center">{{category}}</h4>
                    </div>
                </div>

                <a class="carousel-control-prev" @click="changeCategoryLeft()" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" @click="changeCategoryRight()" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <Bar-Chart :chart-data="graph_data"
                :options="graph_options">
            </Bar-Chart>
        </div>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        watch: {
            data: function(newVal){
                this.updateOptions();
                this.updateData();
            },
            max_number: function(newVal){
                this.updateOptions();
            }
        },
        mounted() {
            this.updateOptions();
            this.updateData();
        },
        props: {
            data: {type: Array, required: true,},
            max_number: {type: Number, required: true,},
            categories: {type: Array, required: true,},
            pieces: {type: Array, required: true,},
        },
        data(){
            return{
                all_pieces: [],
                graph_options: {},
                graph_data: {},
                active_category: 0,
                active_pieces: [],
                max: {},
                min: {},
                avg: 0,
            }
        },
        methods: {
            updateOptions: function(){
                this.graph_options= {
                    respinsive:true,
                    mantainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                max: this.max_number,
                                beginAtZero: true,
                            }
                        }]
                    }
                }
            },
            updateData: function(){
                this.active_pieces = this.pieces.filter(piece => piece.category == this.categories[this.active_category]).map(piece => piece.name);
                this.graph_data = {
                    labels: this.active_pieces,
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

            getTimesPlayed: function(){
                var piece_times_count = [];
                this.all_pieces = [];
                this.active_pieces.forEach(piece =>{
                    var count = this.data.reduce((n, session) => n + (session.piece_name == piece), 0);
                    piece_times_count.push(count);
                    this.all_pieces.push({piece: piece, count: count});
                });

                if(this.all_pieces.length > 0){
                    this.max = this.all_pieces.reduce((m,x)=> m.count>x.count ? m:x);
                    this.min = this.all_pieces.reduce((m,x)=> m.count<x.count ? m:x);
                    this.avg = piece_times_count.reduce((a, b) => a + b, 0) / piece_times_count.length;
                }

                return piece_times_count;
            },

            changeCategoryLeft: function(){
                this.active_category = (this.active_category +this.categories.length -1) % this.categories.length;
                this.updateData();
                return;
            },
            changeCategoryRight: function(){
                this.active_category = (this.active_category +1) % this.categories.length;
                this.updateData();
                return;
            },
        }
    }
</script>
