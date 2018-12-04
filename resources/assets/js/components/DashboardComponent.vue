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
			        <h5 class="card-title">Tides</h5>

			        <carousel
			        	:perPage="1"
			        	:paginationEnabled="true"
			        >

				        <slide
				        	v-for="data in weekTideData"
				        	v-bind:key="weekTideData.index"
				        >
				        	<div class=""><p>{{data.day}}</p></div>

				        	<div style="">
						        <tide-chart-component
						        	:width="200" :height="150"
						        	v-bind:chartdata="data.chartdata"
						        	v-bind:chartoptions="data.chartoptions"
						        />
						    </div>

						    <div class="mt-4">
								<table class="table table-sm table-bordered">
									<tbody>
										<th></th>
										<th>Height</th>
										<th>Time</th>
										<tr v-for="items in data.tableData">
											<th scope="row">{{items.type}}</th>
											<td>{{items.height}}ft</td>
											<td>{{items.time}}</td>
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
	            weekTideData: [],
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

        		const tideData = [];
        		for (var dayData of this.tides) {
        			
        			let day = dayData.day;

    				let labels  = [];
	        		let heights = [];
	        		let tableData = [];

        			for (var tide of dayData.data) {
		        		labels.push(tide.converted_time); 
		        		heights.push(tide.height.toFixed(1));
		        		tableData.push({
		        			time: tide.converted_time,
		        			type: tide.type,
		        			height: tide.height.toFixed(1),
		        		});
					}

					let chartdata = {
						labels: labels,
						datasets: [
							{
								label: 'Tide',
								backgroundColor: 'rgba(24, 125, 160, .3)',
								borderColor: 'rgba(24, 125, 160, 1)',
								data: heights,
							}
						]
					};

					let chartoptions = {
						maintainAspectRatio: false,
						legend: {
							display: false
						}
					};

					let data = {
						day,
						chartdata,
						chartoptions,
						tableData,
					}

					tideData.push(data);
				}

				this.weekTideData = tideData;
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
        	// console.log(this.tides);
        	// console.log(this.weather);
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
</style>