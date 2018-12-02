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

				        <p class="card-text">
				        	<h3>{{this.buoy.wave_height }}ft &#64; {{this.buoy.dominant_period}}s</h3>
					        <h3>{{this.buoy.angle}}&deg; {{ this.buoy.swell_direction }}</h3>
				        </p>
				        <p class="card-text mt-1">On {{this.buoy.observation_time}}</p>
			        	<!-- <div class="float-left">
			        		<div><img src="../../../assets/images/icons/buoy.svg" height="25" alt="Buoy icon" /></div>
			        	</div>
			        	<div class="float-right">
					        <h3>{{this.buoy.wave_height }}ft &#64; {{this.buoy.dominant_period}}s</h3>
					        <h3>{{this.buoy.angle}}&deg; {{ this.buoy.swell_direction }}</h3>
			        	</div>
			        	<div class="clearfix"></div> -->
			        </div>
			        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
			      </div>
			    </div>
			</b-col>
			<b-col cols="12 "lg="4" md="6">
				<div class="card">
			      <div class="card-body">
			        <h5 class="card-title"><img src="../../../assets/images/icons/tide.svg" height="25" alt="Tide icon" /> Tide</h5>
			        
			        <tide-chart-component
			        	v-bind:chartdata="this.chartData"
			        	v-bind:chartoptions="this.chartOptions"
			        />

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
		created() {
			// console.log(this.buoy);
			// console.log(this.tides);
		},
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
			        datasets: [
						{
							label: 'Tide',
							backgroundColor: 'rgba(24, 125, 160, .3)',
							borderColor: 'rgba(24, 125, 160, 1)',
							data: [1, 4, 2, 5]
						}
					]
				},
				chartOptions: {
					responsive: true,
					maintainAspectRatio: false,
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
	        	for (var value of this.tides) {
	        		console.log(value);
	        		labels.push(value.converted_time); 
	        		heights.push(Math.round(value.height));
				}
				this.chartData.labels = labels;
        	},

        },
        components: {
        	CompassComponent,
        }
	}
</script>

<style lang="scss" scoped>
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