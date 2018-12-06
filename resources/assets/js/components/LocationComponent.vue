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
			<b-col cols="6" lg="3">
				<div class="card">
					<div class="card-body card-small">
						<b-row>
							<b-col cols="2" offset-sm="">
								<img src="../../../assets/images/icons/buoy.svg" height="30" alt="Buoy icon" />
							</b-col>
							<b-col cols="10">
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
											style="position: relative; top: -5px;"
										>
											{{data.buoy[0].angle}}&deg; {{data.buoy[0].direction}}
										</div>
									</div>
								</div>
							</b-col>
						</b-row>
						<div class="text-center ft-sm">
							<div>{{data.buoy[0].name}} Buoy - {{data.buoy[0].time_local}}</div>
						</div>
						<div class="text-right"><div><a href="#">Historical</a></div></div>
					</div>
				</div>
			</b-col>
			<b-col cols="6" lg="3">
				<div class="card">
					<div class="card-body card-small">
						<b-row>
							<b-col cols="2" offset-sm="">
								<img src="../../../assets/images/icons/wind.svg" height="25" alt="Buoy icon" />
							</b-col>
							<b-col cols="10">
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
											style="position: relative; top: -5px;"
										>
											 {{data.weather[0].direction}}
										</div>
									</div>
					        	</div>
							</b-col>
						</b-row>
						<div class="text-center ft-sm">
							<div>{{data.weather[0].name}} Station - {{data.buoy[0].time_local}}</div>
						</div>
						<div class="text-right"><div><a href="#">Historical</a></div></div>
					</div>
				</div>
			</b-col>
			<b-col cols="6" lg="3">
				<div class="card">
					<div class="card-body card-small">
						<b-row>
							<b-col cols="2" offset-sm="">
								<img src="../../../assets/images/icons/tide.svg" height="25" alt="Buoy icon" />
							</b-col>
							<b-col cols="10">
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
											style="position: relative; top: -5px;"
										>
											 {{data.tide.direction}}
										</div>
									</div>
					        	</div>
							</b-col>
						</b-row>
						<div class="text-center ft-sm">
							<div>{{data.tide.station_name}} - {{data.tide.time_local}}</div>
						</div>
						<div class="text-right"><div><a href="#">Chart</a></div></div>
					</div>
				</div>
			</b-col>
			<b-col cols="6" lg="3">
				<div class="card">
					<div class="card-body card-small">
						<h5 class="card-title">Weather</h5>
					</div>
				</div>
			</b-col>
		</b-row>

		<b-row>
			<b-col cols="12">
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
												<td>{{datum.wind.wind_speed}}mph {{datum.wind.angle}}</td>
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
	import { Carousel, Slide } from 'vue-carousel';

	export default {
		props: [
			'initialdata',
		],
        data () {
    		return {
	            data: this.$props.initialdata,
            }
        },
        created () {},
        methods: {},
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
	margin-bottom: 15px;
}
</style>