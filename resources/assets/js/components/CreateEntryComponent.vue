<template>
	<b-container fluid id="create-form">
		<b-form @submit="onSubmit" @reset="onReset" v-if="show">
			
			<b-row>
				<b-col class="form-section mb-10"><h3>Location</h3></b-col>
			</b-row>

			<b-row>
				<b-col md="6">
					<b-form-group id="date"
                                label="Date"
                                label-for="date">
						<b-form-input id="date"
									type="date"
									v-model="form.date"
									required>
									placeholder="Enter date"
						</b-form-input>
					</b-form-group>
				</b-col>
				<b-col md="6">
					<b-form-group id="time"
                                label="Time"
                                label-for="time">
						<b-form-input id="time"
									type="time"
									v-model="form.time"
									required>
									placeholder="Enter time"
						</b-form-input>
					</b-form-group>
				</b-col>
			</b-row>

			<b-row>
				<b-col>
					<b-form-group id="spot"
                                label="Spot"
                                label-for="spot-title">
                        <b-form-select id="spot-title"
									:options="spots"
									required
									v-model="form.spots">
                        </b-form-select>
					</b-form-group>
				</b-col>
			</b-row>
			
			<b-row>
				<b-col class="form-section my-10"><h3>Swell</h3></b-col>
			</b-row>

			<b-row>
				<b-col lg="3" md=6 sm="12">
					<b-form-group id="swell-dir"
								label="Direction"
								label-for="swellDir">
						<b-form-select id="swellDir"
									:options="directions"
									required
									v-model="form.swellDir">
                        </b-form-select>
					</b-form-group>
				</b-col>
				<b-col lg="3" md=6 sm="12">
					<b-form-group id=""
								label="Angle (&#176;)"
								label-for="angle">
						<b-form-input id="angle"
									type="text"
									v-model="form.angle"
									required
									placeholder="210">
                        </b-form-input>
					</b-form-group>
				</b-col>
				<b-col lg="3" md=6 sm="12">
					<b-form-group id=""
								label="Height (ft)"
								label-for="swellHeight">
						<b-form-input id="swellHeight"
									type="text"
									v-model="form.swellHeight"
									required
									placeholder="3.3">
                        </b-form-input>
					</b-form-group>
				</b-col>
				<b-col lg="3" md=6 sm="12">
					<b-form-group id=""
								label="Period (seconds)"
								label-for="period">
						<b-form-input id="period"
									type="text"
									v-model="form.period"
									required
									placeholder="18">
                        </b-form-input>
					</b-form-group>
				</b-col>
			</b-row>

			<b-row>
				<b-col class="form-section my-10"><h3>Wind</h3></b-col>
			</b-row>

			<b-row>
				<b-col md="6">
					<b-form-group id=""
								label="Direction"
								label-for="windDir">
						<b-form-select id="windDir"
									:options="directions"
									required
									v-model="form.windDir">
                        </b-form-select>
					</b-form-group>
				</b-col>
				<b-col md="6">
					<b-form-group id=""
								label="Speed (mph)"
								label-for="windSpeed">
						<b-form-input id="windSpeed"
									type="text"
									v-model="form.windSpeed"
									required
									placeholder="5">
                        </b-form-input>
					</b-form-group>
				</b-col>
			</b-row>

			<b-row>
				<b-col class="form-section my-10"><h3>Tide</h3></b-col>
			</b-row>

			<b-row>
				<b-col md="6">
					<b-form-group id=""
								label="Direction"
								label-for="tideCurrent">
						<b-form-select id="tideCurrent"
									:options="tides"
									required
									v-model="form.tideCurrent">
                        </b-form-select>
					</b-form-group>
				</b-col>
				<b-col md="6">
					<b-form-group id=""
								label="Height (ft)"
								label-for="tideHeight">
						<b-form-input id="tideHeight"
									type="text"
									v-model="form.tideHeight"
									required
									placeholder="2.4">
                        </b-form-input>
					</b-form-group>
				</b-col>
			</b-row>

			<b-row>
				<b-col class="form-section my-10"><h3>Actual Surf</h3></b-col>
			</b-row>

			<b-row>
				<b-col md="6">
					<b-form-group id=""
								label="Height (ft)"
								label-for="actualHeight">
						<b-form-input id="actualHeight"
									type="text"
									v-model="form.actualHeight"
									required
									placeholder="3-5">
                        </b-form-input>
					</b-form-group>
				</b-col>
				<b-col md="6">
					<b-form-group id=""
								label="Conditions"
								label-for="conditions">
						<b-form-select id="conditions"
									:options="conditions"
									required
									v-model="form.conditions">
                        </b-form-select>
					</b-form-group>
				</b-col>
			</b-row>

			<b-row>
				<b-col>
					<b-form-group id=""
								label="Score"
								label-for="score">
						<b-form-select id="score"
									:options="ratings"
									required
									v-model="form.score">
                        </b-form-select>
					</b-form-group>
				</b-col>
			</b-row>

			<b-row>
				<b-col>
					<b-form-group id=""
								label="Notes"
								label-for="score">
						<b-form-textarea id="notes"
										placeholder="Enter something..."
										:rows="3"
										:max-rows="6">
										v-model="notes">
						</b-form-textarea>
					</b-form-group>
				</b-col>
			</b-row>

			<!--
			<b-form-group id="exampleInputGroup1"
						label="Email address"
						label-for="exampleInput1"
						description="We'll never share your email with anyone else.">
				<b-form-input id="exampleInput1"
							type="email"
							v-model="form.email"
							required
							placeholder="Enter email">
				</b-form-input>
			</b-form-group>

			<b-form-group id="exampleInputGroup2"
						label="Your Name"
						label-for="exampleInput2">
				<b-form-input id="exampleInput2"
							type="text"
							v-model="form.name"
							required
							placeholder="Enter name">
				</b-form-input>
			</b-form-group>
			-->

			<!--
			<b-form-group id="exampleGroup4">
				<b-form-checkbox-group v-model="form.checked" id="exampleChecks">
					<b-form-checkbox value="me">Check me out</b-form-checkbox>
					<b-form-checkbox value="that">Check that out</b-form-checkbox>
				</b-form-checkbox-group>
			</b-form-group>
			-->
			
			<b-button type="submit" variant="primary">Submit</b-button>
			<b-button type="reset" variant="danger">Reset</b-button>

        </b-form>
    </b-container>
</template>

<script>
	import axios from 'axios';
	import 'bootstrap-vue/dist/bootstrap-vue.css'

	export default {
        data () {
    		return {
                form: {
                date: '',
                time: '',
                spots: null,
                swellDir: null,
                angle: '',
                period: '',
                swellHeight: '',
                windDir: null,
                windSpeed: '',
                tideCurrent: null,
                tideHeight: '',
                actualHeight: '',
                conditions: null,
                score: null,
                notes: '',

                checked: []
            },
            spots: [
                { text: 'Select One', value: null },
                { text: 'Point Dume', value: 0 },
                { text: 'Silver Strand', value: 1 },
                { text: 'Ventura Point', value: 2 },
            ],
            directions: [
                { text: 'Select One', value: null },
                { text: 'N', value: 0 },
                { text: 'NNW', value: 1 },
                { text: 'NW', value: 2 },
                { text: 'WNW', value: 3 },
                { text: 'W', value: 4 },
                { text: 'WSW', value: 5 },
                { text: 'SSW', value: 6 },
                { text: 'SW', value: 7 },
                { text: 'S', value: 8 },
                { text: 'SSE', value: 9 },
                { text: 'SE', value: 10 },
                { text: 'E', value: 11 },
                { text: 'ENE', value: 12 },
                { text: 'NE', value: 13 }
            ],
            conditions: [
                { text: 'Select One', value: null },
                { text: 'Groomed', value: 0 },
                { text: 'Glassy', value: 1 },
                { text: 'Bumpy', value: 2 },
                { text: 'Blown Out', value: 3 },
            ],
            tides: [
                { text: 'Select One', value: null },
                { text: 'Incoming', value: 0 },
                { text: 'Outgoing', value: 1 },
            ],
            ratings: [
                { text: 'Select One', value: null },
                { text: '1', value: 0 },
                { text: '2', value: 1 },
                { text: '3', value: 2 },
                { text: '4', value: 3 },
                { text: '5', value: 4 },
                { text: '6', value: 5 },
                { text: '7', value: 6 },
                { text: '8', value: 7 },
                { text: '9', value: 8 },
                { text: '10', value: 9 },
            ],
            show: true
            }
        },
        methods: {
    		onSubmit (evt) {
                evt.preventDefault();
                alert(JSON.stringify(this.form));
            },
            onReset (evt) {
                evt.preventDefault();
                /* Reset our form values */
                this.form.date = '';
                this.form.time = '';
                this.form.spots = null;
                this.form.swellDir = null;
                this.form.angle = '';
                this.form.period = '';
                this.form.swellHeight = '';
                this.form.windDir = null;
                this.form.windSpeed = '';
                this.form.tideCurrent = null;
                this.form.tideHeight = '';
                this.form.score = null;
                this.form.actualHeight = '';
                this.form.conditions = null;
                this.form.notes = '';

                this.form.checked = [];
                /* Trick to reset/clear native browser form validation state */
                this.show = false;
                this.$nextTick(() => { this.show = true });
            }
        }
	}
</script>
