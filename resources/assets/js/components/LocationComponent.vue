<template>
	<b-container>
		<b-row>
			<b-col cols="12">
				<div class="mb-4">
					<h1>Location</h1>
					<h4><i class="fa fa-map-marker"></i> <span style="margin-left: 5px;">{{data.location}}</span></h4>
				</div>
			</b-col>
		</b-row>
		<b-row>
			<div class="card-container">
				<div class="card buoy">
					<div
						class="card-body card-small"
						v-bind:class="{ open: isOpen.buoy }"
					>
						<div style="position:absolute;top:10px;left:10px;">
							<img src="../../../assets/images/icons/buoy.svg" height="30" alt="Buoy icon" />
						</div>
						<div class="card-details-wrapper">
							<div class="card-details">
								<div class="d-flex justify-content-center">
					        		<div
					        			class="swell-direction ft-lg mr-15"
					        			style="position:relative; top: 12px;"
					        		>
					        			<i
						        			class="fa fa-arrow-down"
						        			v-bind:class="data.buoy[0].direction.toLowerCase().trim()">
						        		</i>
						        	</div>
						        	<div>
										<div class="ft-lg">
											{{data.buoy[0].wave_height}}ft &#64; {{data.buoy[0].dominant_period}}s
										</div>
										<div
											class="ft-md"
											style="position:relative;top:-5px;"
										>
											{{data.buoy[0].angle}}&deg; {{data.buoy[0].direction}}
										</div>
									</div>
								</div>
							</div>
							<div class="text-center ft-md">
								<div class="d-block d-md-none">
									<div>{{data.buoy[0].name}} Buoy</div>
									<div>{{data.buoy[0].time_local}}</div>
								</div>
								<div class="d-none d-md-block">
									<div>{{data.buoy[0].name}} Buoy - {{data.buoy[0].time_local}}</div>
								</div>
							</div>
						</div>
						<div
							class="ft-sm"
							v-on:click="expandCard"
						>
							<div class="card-expand"><a id="buoy" href="#">Historical</a></div>
						</div>

						<div class="mt-40 mb-25">
							<table class="table table-sm table-bordered">
								<tbody>
									<th>Time</th>
									<th>Height</th>
									<th>Angle</th>
									<tr v-for="item in data.buoy">
										<td>{{item.time_local}}</td>
										<td>{{item.wave_height}}ft &#64; {{item.dominant_period}}s</td>
										<td>{{item.angle}}&deg; {{item.direction}}</td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>

			<div class="card-container">
				<div class="card tide">
					<div
						class="card-body card-small"
						v-bind:class="{ open: isOpen.tide }"
					>
						<div style="position:absolute;top:10px;left:10px;">
							<img src="../../../assets/images/icons/tide.svg" height="25" alt="Buoy icon" />
						</div>
						<div class="card-details-wrapper">
							<div class="card-details">
								<div class="d-flex justify-content-center">
									<div
					        			class="tide-direction ft-lg mr-15"
					        			style="position:relative; top: 12px;"
					        		>
					        			<i
						        			class="fa fa-arrow-down"
						        			v-bind:class="data.tide.direction.toLowerCase().trim()">
						        		</i>
						        	</div>
						        	<div>
										<div class="ft-lg">
											{{data.tide.height}}ft
										</div>
										<div
											class="ft-md"
											style="position:relative;top:-5px;"
										>
											 {{data.tide.direction}}
										</div>
									</div>
					        	</div>
							</div>
							<div class="text-center ft-md">
								<div class="d-block d-md-none">
									<div>{{data.tide.station_name}}</div>
									<div>{{data.tide.time_local}}</div>
								</div>
								<div class="d-none d-md-block">
									<div>{{data.tide.station_name}} - {{data.tide.time_local}}</div>
								</div>
							</div>
						</div>
						<div
							class="ft-sm"
							v-on:click="expandCard"
						>
							<div class="card-expand"><a id="tide" href="#">Chart</a></div>
						</div>

						<div class="mt-40 mb-25">
							<table class="table table-sm table-bordered">
								<tbody>
									<th></th>
									<th>Height</th>
									<th>Time</th>
									<tr v-for="items in data.tideChart">
										<th scope="row">{{items.type}}</th>
										<td>{{items.height}}ft</td>
										<td>{{items.converted_time}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="card-container">
				<div class="card wind">
					<div
						class="card-body card-small"
						v-bind:class="{ open: isOpen.wind }"
					>
						<div class="card-details-wrapper">
							<div style="position:absolute;top:10px;left:10px;">
								<img src="../../../assets/images/icons/wind.svg" height="25" alt="Buoy icon" />
							</div>
							<div class="card-details">
								<div class="d-flex justify-content-center">
									<div
					        			class="swell-direction ft-lg mr-15"
					        			style="position:relative; top: 12px;"
					        		>
					        			<i
						        			class="fa fa-arrow-down"
						        			v-bind:class="data.weather[0].direction.toLowerCase().trim()">
						        		</i>
						        	</div>
						        	<div>
										<div class="ft-lg">
											{{data.weather[0].speed}}mph
										</div>
										<div
											class="ft-md"
											style="position:relative;top:-5px;"
										>
											 {{data.weather[0].direction}}
										</div>
									</div>
					        	</div>
							</div>
						</div>
						<div class="text-center ft-md">
							<div class="d-block d-md-none">
								<div>{{data.weather[0].name}} Station</div>
								<div>{{data.buoy[0].time_local}}</div>
							</div>
							<div class="d-none d-md-block">
								<div>{{data.weather[0].name}} Station - {{data.weather[0].time_local}}</div>
							</div>
						</div>
						<div
							class="ft-sm"
							v-on:click="expandCard"
						>
							<div class="card-expand"><a id="wind" href="#">Historical</a></div>
						</div>

						<div class="mt-40 mb-25">
							<table class="table table-sm table-bordered">
								<tbody>
									<th>Time</th>
									<th>Data</th>
									<tr v-for="item in data.weather">
										<td>{{item.time_local}}</td>
										<td>{{item.speed}}mph {{item.direction}}</td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>

			<div class="card-container">
				<div class="card weather">
					<div
						class="card-body card-small"
						v-bind:class="{ open: isOpen.weather }"
					>
						<div class="card-details-wrapper">
							<div style="position:absolute;top:10px;left:10px;">
								<img src="../../../assets/images/icons/sun.svg" height="28" alt="Buoy icon" />
							</div>
							<div class="card-details">
								<div class="d-flex justify-content-center">
									<div>
										<div class="ft-md">
											<span style="font-weight: bold;">Sunrise</span>: {{data.weather[0].sunrise}}
										</div>
										<div
											class="ft-md"
											style="position:relative;top:-5px;"
										>
											 <span style="font-weight: bold;">Sunset</span>: {{data.weather[0].sunset}}
										</div>
									</div>
					        	</div>
							</div>
						</div>
						<div class="text-center ft-md">
							<div>
								<img id="water-temp" src="../../../assets/images/icons/water.svg" alt="Water icon" />
								{{data.buoy[0].water_temp}}&deg;
							</div>
						</div>
						<div
							class="ft-sm"
							v-on:click="expandCard"
						>
						</div>
					</div>
				</div>
			</div>
		</b-row>

		<b-row>
			<div class="px-5" style="width:100%;">
				<div class="card">
			      <div class="card-body">
			        <h3 class="card-title">Predicted Conditions</h3>
			        	<carousel
				        	:perPage="1"
				        	:paginationEnabled="true"
				        >
					        <slide
					        	v-for="items in data.predictions"
					        	v-bind:key="data.predictions.index"
					        >
					        	<h5>{{items.date}}</h5>
							    <div class="mt-4">
									<table class="table table-bordered table-striped">
										<tbody>
											<tr class="">
												<th></th>
												<th>NOAA</th>
												<th>Tide</th>
												<th>Wind</th>
											</tr>
											<tr v-for="datum in items.data">
												<th scope="row">{{datum.time_local}}</th>
												<td>Wave: {{datum.swell.wave_height}}ft &#64; {{datum.swell.wave_period}}s - {{datum.swell.swell_direction}}&deg; {{datum.swell.angle}} <br>
													Swell: {{datum.swell.swell_height.toFixed(1)}}ft &#64; {{datum.swell.swell_period}}s</td>
												<td>{{datum.tide.height}}ft {{datum.tide.direction}}</td>
												<td>{{datum.weather.wind_speed}}mph {{datum.weather.angle}}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</slide>
						</carousel>
				      </div>
			    </div>
			</div>

		</b-row>
    </b-container>
</template>

<script>
	import { Carousel, Slide } from 'vue-carousel';

	export default {
		props: [
			'initialdata',
		],
        data () {
    		return {
	            data: this.$props.initialdata,
	            isOpen: {
	            	buoy: false,
	            	tide: false,
	            	wind: false,
	            	weather: false,
	            },
            }
        },
        created () {},
        methods: {
        	expandCard: function(e) {
        		e.preventDefault();
        		console.log(e.target.id);
        		let id = e.target.id;

        		this.isOpen[id] = !this.isOpen[id];
        		// this.isOpen = !this.isOpen;
        	},
        },
        mounted() {
        	console.log(this.$props.initialdata);
        },
        components: {
        	Carousel,
			Slide
		},
	}
</script>

<style lang="scss" scoped>
.card {
	margin-bottom: 10px;
	padding-left: 5px;
	padding-right: 5px;
	.card-expand {
		position: absolute;
		bottom: 6px;
		right: 10px;
	}
}

img#water-temp {
	height: 20px;
}

.card-details-wrapper {
	margin-top: 0px;
}

@media (min-width: 576px) {
	.card-details-wrapper {
		margin-top: 0px;
	}
}

@media (min-width: 768px) {
	.card-details-wrapper {
		margin-top: 15px;
	}
}

@media (min-width: 992px) {
	.card-details-wrapper {
		margin-top: 0px;
	}
}

@media (min-width: 1200px) {
	.card-details-wrapper {
		margin-top: 10px;
	}
}


</style>