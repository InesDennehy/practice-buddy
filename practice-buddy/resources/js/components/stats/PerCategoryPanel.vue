<template>
    <div class="card category border-0 shadow">
        <div class="card-header modal-header category-header">
            <h3 class="card-title m-0 font-weight-light">Times Studied per category</h3>
        </div>
        <div class="card-body">
            <h4>Max: {{max.count}} ({{max.category}})</h4>
            <h4>Min: {{min.count}} ({{min.category}})</h4>
            <h4>Avg: {{avg}}</h4>
            <Radar-Chart :chart-data="graph_data"
                :options="graph_options">
            </Radar-Chart>
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
        },
        data(){
            return{
                graph_data: {},
                graph_options: {},
                categories_data: [],
                max: {},
                min: {},
                avg: 0,
            }
        },
        methods: {
            updateOptions: function(){
                this.graph_options = {
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
            },
            updateData: function(){
                this.graph_data = {
                    labels: this.categories,
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
                var category_times_count = [];
                this.categories_data = []
                this.categories.forEach(category =>{
                    var count = this.data.reduce((n, session) => n + (session.category_name == category), 0);
                    category_times_count.push(count);
                    this.categories_data.push({category: category, count: count});
                });

                if(this.categories_data.length > 0){
                    this.max = this.categories_data.reduce((m,x)=> m.count>x.count ? m:x);
                    this.min = this.categories_data.reduce((m,x)=> m.count<x.count ? m:x);
                    this.avg = category_times_count.reduce((a, b) => a + b, 0) / category_times_count.length;
                }

                return category_times_count;
            },
        }
    }
</script>
