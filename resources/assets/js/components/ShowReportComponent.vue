<template>

	<swell-component
		v-bind:initialdata="this.swellData"
	></swell-component>

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
    			data: this.$props.initialdata,
    			swellData: {
    				date: this.$props.initialdata.date,
					buoys: {
						start: {
							height: this.$props.initialdata.start_swell_height,
							period: this.$props.initialdata.start_swell_period,
							angle: this.$props.initialdata.start_swell_angle,
							direction: this.$props.initialdata.start_swell_dir,
						},
						end:  {
							height: this.$props.initialdata.end_swell_height,
							period: this.$props.initialdata.end_swell_period,
							angle: this.$props.initialdata.end_swell_angle,
							direction: this.$props.initialdata.end_swell_dir,
						},
						average: {
							height: this.$props.initialdata.avg_swell_height,
							period: this.$props.initialdata.avg_swell_period,
							angle: this.$props.initialdata.avg_swell_angle,
							direction: this.$props.initialdata.avg_swell_dir,
						}
					},
					wind: {
						start: {
							speed: this.$props.initialdata.start_wind_speed,
							angle: this.$props.initialdata.start_wind_angle,
							direction: this.$props.initialdata.start_wind_dir,
						},
						end: {
							speed: this.$props.initialdata.end_wind_speed,
							angle: this.$props.initialdata.end_wind_angle,
							direction: this.$props.initialdata.end_wind_dir,
						}
					},
					tide: {
						start: this.$props.initialdata.start_tide_height,
						end: this.$props.initialdata.end_tide_height,
						direction: this.$props.initialdata.tide_dir,
					}
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
