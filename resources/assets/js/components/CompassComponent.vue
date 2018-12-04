<template>

	<div class="compass">
		<div class="north">N</div>
		<div class="west">W</div>
		<div class="east">E</div>
		<div class="south">S</div>
		<div class="direction">
			<p>{{ this.data.angle }}&deg; {{ this.data.direction }}<span>{{ this.data.height.toFixed(1) }}ft @ {{ this.data.period }}s</span></p>
		</div>
		<div class="arrow"
			v-bind:class="this.data.direction.toLowerCase().trim()">
		</div>
	</div>

</template>

<script>
	export default {
		created() {
			// console.log(this.$props.initialdata);
		},
		props: [
			'initialdata',
		],
        data () {
    		return {
    			data: this.$props.initialdata,
            }
        },
	}
</script>
