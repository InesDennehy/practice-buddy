<script>
    import { Radar, mixins } from 'vue-chartjs'
    const { reactiveProp } = mixins

    export default {
        extends: Radar,
        mixins: [reactiveProp],
        props: ['options'],
        mounted() {
            this.renderChart(this.chartData, this.options);
        },
        watch: {
            options: function() {
                this.$data._chart.options = this.options;
                this.$data._chart.update();
            }
        }
    }
</script>
