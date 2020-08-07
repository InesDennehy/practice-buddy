<template>
    <div class="card category border-0 shadow">
        <div class="card-header modal-header category-header">
            <h3 class="card-title m-0 font-weight-light">Pieces studied per day</h3>
        </div>
        <div class="card-body">
            <h5>Max: {{max.count}} ({{max.date}})</h5>
            <h5>Min: {{min.count}} ({{min.date}})</h5>
            <h5 style="margin-bottom: 30px">Avg: {{avg}}</h5>
            <div>
                <span>
                    <a class="carousel-control-prev" style="top:180px;" @click="$emit('change-left')" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                </span>
                <span>
                    <Line-Chart style="width:90%;" :chart-data="graph_data"
                        :options="graph_options">
                    </Line-Chart>
                </span>
                <span>
                    <a class="carousel-control-next" style="top:180px;" @click="$emit('change-right')" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        watch:{
            max_pieces: function(newVal){
                this.updateOptions();
            },
            data: function(newVal){
                this.updateData();
            },
        },
        mounted() {},
        props: {
            data: {type: Array, required: true,},
            time_range: {type: Array, required: true,},
            max_pieces: {type: Number, required: true,}
        },
        data(){
            return{
                graph_data: {},
                graph_options: {},
                days_data: [],
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
                                max: this.max_pieces,
                                min: 0,
                            }
                        }]
                    }
                }
            },
            updateData: function(){
                var data_days_count = [];
                this.days_data = [];
                this.time_range.forEach(date => {
                    var count = this.data.reduce((n, session) => n + (session.created_at == date), 0);
                    data_days_count.push(count);
                    this.days_data.push({date: date, count: count});
                });

                if(this.days_data.length > 0){
                    this.max = this.days_data.reduce((m,x)=> m.count>x.count ? m:x);
                    this.min = this.days_data.reduce((m,x)=> m.count<x.count ? m:x);
                    this.avg = (data_days_count.reduce((a, b) => a + b, 0) / data_days_count.length).toFixed(2);
                }

                this.graph_data = {
                    labels: this.time_range,
                    datasets: [{
                        label: 'number of pieces studied',
                        data: data_days_count,
                        backgroundColor: [
                            'rgba(22,137,211,0.2)',
                        ],
                        borderColor: [
                            'rgba(53,53,148,1)',
                        ],
                        borderWidth: 1
                    }]
                }
            },
        }
    }
</script>
