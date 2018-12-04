<template>
	<b-container>
		<b-row>
			<b-col cols="12">
				<div class="mb-4">
					<h1>Dashboard</h1>
					<h4><i class="fa fa-map-marker"></i> <span style="margin-left: 5px;">Santa Monica, CA</span></h4>
				</div>
			</b-col>
		</b-row>
		<b-row>
			<b-col cols="12" md="6">
				<div class="card">
			      <div class="card-body">
		        	<h5 class="card-title">Conditions</h5>

			      </div>
			    </div>
			</b-col>

			<b-col cols="12" md="6">
				<div class="card">
			      <div class="card-body">
			        <h5 class="card-title">Tides</h5>
				        <!-- <div>
					        <tide-chart-component
					        	:width="200" :height="150"
					        	v-bind:chartdata="this.chartData"
					        	v-bind:chartoptions="this.chartOptions"
					        />
					    </div>

					    <div class="mt-4">
							<table class="table table-sm table-bordered">
								<tbody>
									<tr v-for="tide in tides">
										<th scope="row">{{tide.type}}</th>
										<td>{{tide.height}}ft</td>
										<td>{{tide.converted_time}}</td>
									</tr>
								</tbody>
							</table>
						</div> -->
			      </div>
			    </div>
			</b-col>

		</b-row>
    </b-container>
</template>

<script>
	import TideChart from './TideChart.vue';

	export default {
		props: [
			'initialdata',
		],
        data () {
    		return {
	            buoy: this.$props.initialdata.buoy,
	            tides: this.$props.initialdata.tides,
	            weather: this.$props.initialdata.weather,
            }
        },
        created () {},
        methods: {},
        mounted() {
        	console.log(this.$props.initialdata);
        },
        components: {}
	}
</script>

<style lang="scss" scoped>
.card {
	margin-bottom: 15px;
}
</style>