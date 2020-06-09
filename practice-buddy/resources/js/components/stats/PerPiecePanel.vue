<template>
    <div class="card category border-0 shadow">
        <div class="card-header modal-header category-header">
            <h3 class="card-title m-0 font-weight-light">Times Studied per piece</h3>
        </div>
        <div class="card-body">
            <h4>Max: {{max.count}} ({{max.piece}})</h4>
            <h4>Min: {{min.count}} ({{min.piece}})</h4>
            <h4>Avg: {{avg}}</h4>
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
        },
        mounted() {
            this.updateOptions();
            this.updateData();
        },
        props: {
            data: {type: Array, required: true,},
            categories: {type: Array, required: true,},
            pieces: {type: Array, required: true,},
        },
        data(){
            return{
                all_pieces: [],
                graph_options: {},
                graph_data: {},
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
                                beginAtZero: true,
                            }
                        }]
                    }
                }
            },
            updateData: function(){
                this.graph_data = {
                    labels: this.pieces,
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
                this.pieces.forEach(piece =>{
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
        }
    }
</script>
