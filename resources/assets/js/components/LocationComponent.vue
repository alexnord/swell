<template>
	<b-container>
		<b-row>
			<b-col cols="12">
				<div class="mb-4">
					<h1>Location</h1>
					<h4><i class="fa fa-map-marker"></i> <span style="margin-left: 5px;">Point Dume, CA</span></h4>
				</div>
			</b-col>
		</b-row>
		<b-row>
			<b-col cols="4">
				<div class="card">
					<div class="card-body">
						<h3 class="card-title">Tides</h3>
					</div>
				</div>
			</b-col>
			<b-col cols="4">
				<div class="card">
					<div class="card-body">
						<h3 class="card-title">Conditions</h3>
					</div>
				</div>
			</b-col>
			<b-col cols="4">
				<div class="card">
					<div class="card-body">
						<h3 class="card-title">Wind</h3>
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
					        	v-for="items in data"
					        	v-bind:key="data.index"
					        >
					        	<h5>{{items.date}}</h5>
							    <div class="mt-4">
									<table class="table table-bordered table-striped">
										<tbody>
											<tr class="">
												<th></th>
												<th>Waves</th>
												<th>Tide</th>
												<th>Wind</th>
											</tr>
											<tr v-for="datum in items.data">
												<th scope="row">{{datum.time_local}}</th>
												<td>{{datum.swell.wave_height}}ft &#64; {{datum.swell.wave_period}}s - {{datum.swell.swell_direction}}&deg; {{datum.swell.angle}} (Swell: {{datum.swell.swell_height.toFixed(1)}}ft &#64; {{datum.swell.swell_period}}s)</td>
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
        	// console.log(this.$props.initialdata);
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