<template>
	<b-container>
		<b-row>
			<b-col cols="12">
				<div class="mb-4">
					<h1>Dashboard</h1>
				</div>
			</b-col>
		</b-row>
		<b-row>
			<b-col cols="12 "lg="4" md="4">
				<div class="card">
			      <div class="card-body">
			        <!-- <h5 class="card-title">Buoy</h5> -->
			        <div>
			        	<h5 class="card-title"><img src="../../../assets/images/icons/buoy.svg" height="25" alt="Buoy icon" /> Buoy</h5>

			        	<!-- <compass-component
							v-bind:initialdata="this.compassData"
						></compass-component> -->

				        <div class="d-flex align-items-center">
					        <div class="d-flex align-items-center">
					        	<div class="dashboard-swell-direction">
					        		<div><i
						        			class="fa fa-arrow-down"
						        			v-bind:class="this.buoy.swell_direction.toLowerCase().trim()">
						        		</i>
						        	</div>
					        	</div>
					        	<div class="">
							        <h3>{{this.buoy.wave_height }}ft &#64; {{this.buoy.dominant_period}}s</h3>
							        <h3>{{this.buoy.angle}}&deg; {{ this.buoy.swell_direction }}</h3>
					        	</div>
					        </div>
					    </div>
			        	<div class="clearfix"></div>
			        	<p class="card-text mt-1">On {{this.buoy.observation_time}}</p>
			        </div>
			        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
			      </div>
			    </div>
			</b-col>
			<b-col cols="12 "lg="4" md="6">
				<div class="card">
			      <div class="card-body">
			        <h5 class="card-title"><img src="../../../assets/images/icons/tide.svg" height="25" alt="Tide icon" /> Tide</h5>
			        
		        	<div class=""><p>{{this.$props.initialdata.date}}</p></div>

			        <div class="">
				        <tide-chart-component
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
			<b-col cols="12 "lg="4" md="6">
				<div class="card">
			      <div class="card-body">
			        <h5 class="card-title">Wind</h5>
			        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
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
					responsive: true,
					maintainAspectRatio: true,
					aspectRatio: 1,
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