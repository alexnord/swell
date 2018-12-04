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
			        <div>
			        	<h5 class="card-title"> Conditions</h5>

				        <div class="d-flex justify-content-center">
				        	<div
					        	style="top: 18px;position: relative;margin-right: 50px;"
				        	>
				        		<img src="../../../assets/images/icons/buoy.svg" height="50" alt="Buoy icon" />
				        	</div>

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
			        	<p class="card-text mt-1 text-center">{{this.buoy.buoy_name}} Buoy - {{this.buoy.observation_time}}</p>
			        </div>

			        <div class="d-flex justify-content-center">
			        		<div
					        	style="top:18px;position:relative;margin-right:50px;"
				        	>
				        		<img src="../../../assets/images/icons/wind.svg" height="50" alt="Wind icon" />
				        	</div>

				        	<div class="dashboard-swell-direction" style="margin-right: 20px;">
				        		<div><i
					        			class="fa fa-arrow-down"
					        			v-bind:class="this.weather.wind_direction.toLowerCase().trim()">
					        		</i>
					        	</div>
				        	</div>
				        	<div class="" style="font-size: 24px; position: relative; top: 8px;">
						        <div style="margin-bottom: -8px;">{{this.weather.speed.toFixed(0) }}mph</div>
						        <div>{{this.weather.angle}}&deg; {{ this.weather.wind_direction }}</div>
				        	</div>
					    </div>
					    <p class="card-text mt-1 text-center">{{this.weather.location_name}} - {{this.weather.observation_time}}</p>
			        </div>

			      </div>
			    </div>
			</b-col>

			<b-col cols="12" md="6">
				<div class="card">
			      <div class="card-body">
			        <h5 class="card-title"><img src="../../../assets/images/icons/tide.svg" height="0" alt="Tide icon" /> Tides</h5>

			        <carousel
			        	:perPage="1"
			        	:paginationEnabled="false"
			        >
						<slide>
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
						</slide>

						<slide>
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
						</slide>

					</carousel>

			      </div>
			    </div>
			</b-col>

		</b-row>
    </b-container>
</template>

<script>
	import axios from 'axios';
	import { Carousel, Slide } from 'vue-carousel';
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
					maintainAspectRatio: false,
					legend: {
						display: false
					}
				},
				slide: 0,
				sliding: null,
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
        	onSlideStart (slide) {
				this.sliding = true
			},
			onSlideEnd (slide) {
				this.sliding = false
			},
        },
        mounted() {
        	// console.log(this.buoy);
        	console.log(this.weather);
        },
        components: {
			Carousel,
			Slide
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