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
			<b-col cols="12">
				<div class="card">
			      <div class="card-body">
			        <h5 class="card-title">Tides</h5>
					    <div class="mt-4">
							<table class="table table-sm table-bordered">
								<tbody>
									<tr>
										<th></th>
										<th>Swell</th>
										<th>Tide</th>
										<th>Wind</th>
									</tr>
									<tr v-for="datum in data[0].data">
										<th scope="row">{{datum.time_local}}</th>
										<td>{{datum.swell.swell_height}}ft &#64; {{datum.swell.swell_period.toFixed(0)}}s - {{datum.swell.swell_direction.toFixed(0)}}&deg; {{datum.swell.angle}}</td>
										<td>{{datum.tide.height}}ft {{datum.tide.direction}}</td>
										<td>{{datum.wind.wind_speed.toFixed(0)}}mph {{datum.wind.angle}}</td>
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
	import TideChart from './TideChart.vue';

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
        components: {}
	}
</script>

<style lang="scss" scoped>
.card {
	margin-bottom: 15px;
}
</style>