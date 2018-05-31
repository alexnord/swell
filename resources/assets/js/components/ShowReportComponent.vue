<template>

	<div>

		<b-row>
			<b-col>
				<h2>{{ this.swellData.formattedDate }}</h2>
				<h3>{{ this.swellData.startTime }} - {{ this.swellData.endTime }}</h3>
			</b-col>
		</b-row>

		<swell-component
			v-bind:initialdata="this.swellData"
		></swell-component>

		<b-row>
			<b-col>
				<h3>Score: {{ this.swellData.score }}</h3>
				<h3>Actual Height: {{ this.swellData.actualHeight }}ft</h3>
				<h3>{{ this.swellData.notes }}</h3>
			</b-col>
		</b-row>

	</div>

</template>

<script>
	import SwellComponent from './SwellComponent.vue';

	export default {
		created() {
			console.log(this.$props.initialdata);
		},
		props: [
			'initialdata',
		],
        data () {
    		return {
    			swellData: {
	    			formattedDate: this.$props.initialdata.formatted_date,
	    			startTime: this.$props.initialdata.formatted_start_time,
	    			endTime: this.$props.initialdata.formatted_end_time,
					buoys: {
						start: {
							height: this.$props.initialdata.start_swell_height,
							period: this.$props.initialdata.start_swell_period,
							angle: this.$props.initialdata.start_swell_angle,
							direction: this.$props.initialdata.start_swell_dir.toUpperCase(),
						},
						end:  {
							height: this.$props.initialdata.end_swell_height ? this.$props.initialdata.end_swell_height : 'NA',
							period: this.$props.initialdata.end_swell_period ? this.$props.initialdata.end_swell_period : 'NA',
							angle: this.$props.initialdata.end_swell_angle ? this.$props.initialdata.end_swell_angle : 'NA',
							direction: this.$props.initialdata.end_swell_dir ? this.$props.initialdata.end_swell_dir.toUpperCase() : 'NA',
						},
						average: {
							height: this.$props.initialdata.avg_swell_height,
							period: this.$props.initialdata.avg_swell_period,
							angle: this.$props.initialdata.avg_swell_angle,
							direction: this.$props.initialdata.avg_swell_dir.toUpperCase(),
						}
					},
					wind: {
						start: {
							speed: this.$props.initialdata.start_wind_speed,
							angle: this.$props.initialdata.start_wind_angle,
							direction: this.$props.initialdata.start_wind_dir.toUpperCase(),
						},
						end: {
							speed: this.$props.initialdata.end_wind_speed ? this.$props.initialdata.end_wind_speed : 'NA',
							angle: this.$props.initialdata.end_wind_angle ? this.$props.initialdata.end_wind_angle : 'NA',
							direction: this.$props.initialdata.end_wind_dir ? this.$props.initialdata.end_wind_dir.toUpperCase() : 'NA',
						}
					},
					tide: {
						start: this.$props.initialdata.start_tide_height,
						end: this.$props.initialdata.end_tide_height,
						direction: this.$props.initialdata.tide_dir,
					},
					score: this.$props.initialdata.score,
					actualHeight: this.$props.initialdata.actual_surf_height,
					notes: this.$props.initialdata.notes,
				}
            }
        },
        methods: {
			randomMethod() {
				return;
			}
        },
        components: {
        	SwellComponent
        }
	}
</script>
