// TideChart.js
<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: [
    'chartdata',
    'chartoptions',
  ],
  data () {
    return {
      options: {
        responsive: true,
        maintainAspectRatio: false
      },
    }
  },
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart(this.$props.chartdata, this.$props.chartoptions);
  }
}
</script>
