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
									required
									placeholder="Enter date">
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
									required
									placeholder="Enter time">
						</b-form-input>
					</b-form-group>
				</b-col>
			</b-row>

			<b-row>
				<b-col>
					<b-form-group id="location"
                                label="Location"
                                label-for="location-title">
                        <model-select :options="locations"
									v-model="form.location"
									required
									placeholder='Select One'>
						</model-select>
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
                        <model-select :options="directions"
									v-model="form.swellDir"
									required
									placeholder='Select One'>
						</model-select>
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
                        <model-select :options="directions"
									v-model="form.windDir"
									required
									placeholder='Select One'>
						</model-select>
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
                        <model-select :options="tides"
									v-model="form.tideCurrent"
									required
									placeholder='Select One'>
						</model-select>
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
                        <model-select :options="conditions"
									v-model="form.conditions"
									required
									placeholder='Select One'>
						</model-select>
					</b-form-group>
				</b-col>
			</b-row>

			<b-row>
				<b-col class="form-section my-10"><h3>Rating</h3></b-col>
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
								label-for="notes">
						<b-form-textarea id="notes"
										v-model="form.notes"
										placeholder="Enter something"
										:rows="3"
										:max-rows="6">
						</b-form-textarea>
					</b-form-group>
				</b-col>
			</b-row>
			
			<b-button type="submit" variant="primary">Submit</b-button>
			<b-button type="reset" variant="danger">Reset</b-button>

        </b-form>
    </b-container>
</template>

<script>
	import axios from 'axios';
	import { ModelSelect } from 'vue-search-select'

	export default {
		props: [
			'initialuserid',
			'initiallocations',
			'initialdirections',
			'initialtides',
			'initialconditions',
		],
        data () {
    		return {
                form: {
	                date: '',
	                time: '',
	                location: null,
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
	            },
	            userId: this.$props.initialuserid,
	            locations: this.$props.initiallocations,
	            directions: this.$props.initialdirections,
	            conditions: this.$props.initialconditions,
	            tides: this.$props.initialtides,
	            ratings: [
		            { text: 'Select One', value: null },
	                { text: '1', value: '0' },
	                { text: '2', value: '1' },
	                { text: '3', value: '2' },
	                { text: '4', value: '3' },
	                { text: '5', value: '4' },
	                { text: '6', value: '5' },
	                { text: '7', value: '6' },
	                { text: '8', value: '7' },
	                { text: '9', value: '8' },
	                { text: '10', value: '9' },
	            ],
	            show: true
            }
        },
        methods: {
    		onSubmit (evt) {
                evt.preventDefault();
                this.show = false;

                axios.post(`/api/reports`, {
                	'user_id': this.userId,
                	'date': this.form.date,
                	'time': this.form.time,
                	'location_id': this.form.location,
                	'swell_dir_id': this.form.swellDir,
                	'swell_angle': this.form.angle,
                	'swell_height': this.form.swellHeight,
                	'swell_period': this.form.period,
                	'wind_dir_id': this.form.windDir,
                	'wind_speed': this.form.windSpeed,
                	'tide_dir_id': this.form.tideCurrent,
                	'tide_height': this.form.tideHeight,
                	'score': this.form.score,
                	'actual_surf_height': this.form.actualHeight,
                	'condition_id': this.form.conditions,
                	'score': this.form.score,
                	'notes': this.form.notes,
                }).then(response => {
					console.log(response.data);
					this.show = true;
				}).catch(error => {
					console.log(error);
					alert('There was an error submitting your vote');
				})
            },
            onReset (evt) {
                evt.preventDefault();
                /* Reset our form values */
                this.form.date = '';
                this.form.time = '';
                this.form.location = null;
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

                /* Trick to reset/clear native browser form validation state */
                this.show = false;
                this.$nextTick(() => { this.show = true });
            }
        },
        components: {
			ModelSelect
	    }
	}
</script>
