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
			        <!-- <h5 class="card-title">Buoy</h5> -->
			        <div>
			        	<h5 class="card-title"><img src="../../../assets/images/icons/buoy.svg" height="25" alt="Buoy icon" /> Buoy</h5>

			        	<!-- <compass-component
							v-bind:initialdata="this.compassData"
						></compass-component> -->

				        <div class="d-flex justify-content-center">
				        	<div class="dashboard-swell-direction" style="margin-right: 20px;">
				        		<div><i
					        			class="fa fa-arrow-down"
					        			v-bind:class="this.buoy.swell_direction.toLowerCase().trim()">
					        		</i>
					        	</div>
				        	</div>
				        	<div class="" style="font-size: 24px; position: relative; top: 8px;">
						        <div style="margin-bottom: -8px;">{{this.buoy.wave_height.toFixed(1) }}ft &#64; {{this.buoy.dominant_period}}s</div>
						        <div>{{this.buoy.angle}}&deg; {{ this.buoy.swell_direction }}</div>
				        	</div>
					    </div>
			        	<div class="clearfix"></div>
			        	<p class="card-text mt-1 text-center">On {{this.buoy.observation_time}}</p>
			        </div>

			      </div>
			    </div>
			</b-col>
			<b-col cols="12" md="6">
				<div class="card">
			      <div class="card-body">
			        <h5 class="card-title"><img src="../../../assets/images/icons/tide.svg" height="25" alt="Tide icon" /> Tide</h5>
			        
		        	<div class=""><p>{{this.$props.initialdata.date}}</p></div>

			        <div style="">
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
					</div>

			      </div>
			    </div>
			</b-col>
		</b-row>
    </b-container>
</template>

<script>
	import axios from 'axios';
	import CompassComponent from './CompassComponent.vue';
	import TideChart from './TideChart.vue';

	export default {
		props: [
			'initialdata',
		],
        data () {
    		return {
	            buoy: this.$props.initialdata.buoy,
	            tides: this.$props.initialdata.tides,
	            compassData: {
					height: this.$props.initialdata.buoy.wave_height,
					period: this.$props.initialdata.buoy.dominant_period,
					angle: this.$props.initialdata.buoy.angle,
					direction: this.$props.initialdata.buoy.swell_direction,
				},
				chartData: {
			        labels: [],
			        datasets: [],
				},
				chartOptions: {
					// responsive: true,
					maintainAspectRatio: false,
					// aspectRatio: 2,
					legend: {
						display: false
					}
				},
            }
        },
        created () {
        	this.setChartData();
        },
        methods: {
        	setChartData() {
        		const labels  = [];
        		const heights = [];
        		const table   = [];
	        	for (var value of this.tides) {
	        		labels.push(value.converted_time); 
	        		heights.push(value.height.toFixed(1));
				}
				this.chartData.labels = labels;
				this.chartData.datasets = [
					{
						label: 'Tide',
						backgroundColor: 'rgba(24, 125, 160, .3)',
						borderColor: 'rgba(24, 125, 160, 1)',
						data: heights,
					}
				]
        	},

        },
        mounted() {
        	// console.log(this.buoy);
        	console.log(this.tides);
        },
        components: {
        	CompassComponent,
        }
	}
</script>

<style lang="scss" scoped>
.card {
	margin-bottom: 15px;
}
.card-title {
	img {
		margin-right: 5px;
	}
}
.details {
	position: absolute;
	bottom: -10px;
	right: 10px;
}
</style>