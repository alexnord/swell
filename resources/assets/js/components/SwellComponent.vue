<template>
	<b-row>
		<b-col md=6 class="d-flex justify-content-center mb-30">
			<compass-component
				v-bind:initialdata="this.data.buoys.average"
			></compass-component>
		</b-col>
		<b-col md=6 class="vertical-center mt-10">
			<b-row>
				<div>
					<p class="heading-label">Buoys</p>
				</div>
				<div class="buoy-this.data">
					<p class="ft-16 my-0"><span class="ft-bold">Start</span>: {{ this.data.buoys.start.height }}ft @ {{ this.data.buoys.start.period }}s - {{ this.data.buoys.start.angle }}&deg; {{ this.data.buoys.start.direction }}</p>
					<p class="ft-16 my-0"><span class="ft-bold">End</span>: {{ this.data.buoys.end.height }}ft @ {{ this.data.buoys.end.period }}s - {{ this.data.buoys.end.angle }}&deg; {{ this.data.buoys.end.direction }}</p>
				</div>
			</b-row>
			<b-row class="mt-20">
				<div>
					<p class="heading-label">Wind</p>
				</div>
				<div class="buoy-this.data">
					<p class="ft-16 my-0"><span class="ft-bold">Start</span>: {{ this.data.wind.start.speed }}mph {{ this.data.wind.start.direction }}</p>
					<p class="ft-16 my-0"><span class="ft-bold">End</span>: {{ this.data.wind.end.speed }}mph {{ this.data.wind.end.direction }}</p>
				</div>
			</b-row>
			<b-row class="mt-20">
				<div>
					<p class="heading-label">Tide</p>
				</div>
				<div class="buoy-this.data">
					<p class="ft-16 my-0"><span class="ft-bold">Start</span>: {{ this.data.tide.start }}ft</p>
					<p class="ft-16 my-0"><span class="ft-bold">End</span>: {{ this
					.data.tide.end }}ft</p>
					<p class="ft-16 my-0"><span class="ft-bold">Direction</span>: {{ this.data.tide.direction }}</p>
				</div>
			</b-row>
		</b-col>
	</b-row>

</template>

<script>
	import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
	import faLocationArrow from '@fortawesome/fontawesome-free-solid/faLocationArrow'
	import SwellComponent from './SwellComponent.vue';
	import CompassComponent from './CompassComponent.vue';

	export default {
		created() {
			console.log();
		},
		props: [
			'initialdata',
		],
        data () {
    		return {
    			data: this.$props.initialdata,
            }
        },
        methods: {
			randomMethod() {
				return;
			}
        },
        computed: {
			icon () {
				return faLocationArrow
			}
		},
        components: {
        	FontAwesomeIcon,
        	CompassComponent,
        }
	}
</script>
