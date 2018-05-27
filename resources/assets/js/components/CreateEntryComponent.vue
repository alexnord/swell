<template>
	<b-container fluid id="create-form">

		<b-row class="d-flex justify-content-center">
			<b-col>
				<b-alert :show="successDismissCountDown"
						variant="success"
						@dismissed="successDismissCountDown=0">
					<p>Record successfully created!</p>
				</b-alert>
				<b-alert :show="errorDismissCountDown"
						variant="danger"
						@dismissed="errorDismissCountDown=0">
					<p>An error occurred processing your request.</p>
				</b-alert>
			</b-col>
		</b-row>

		<b-form @submit="onSubmitRequest">
			
			<b-row>
				<b-col>
					<b-row>
						<b-col md="3">
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
						<b-col md="3">
							<b-form-group id="date"
		                                label="Date"
		                                label-for="date">
								<b-form-input id="date"
											type="date"
											v-model="form.date"
											required
											:value="form.date"
											placeholder="Enter date">
								</b-form-input>
							</b-form-group>
						</b-col>
						<b-col md="3">
							<b-form-group label="Start Time"
		                                label-for="start_time">
								<b-form-input id="start_time"
											type="time"
											v-model="form.startTime"
											required
											placeholder="Enter start time">
								</b-form-input>
							</b-form-group>
						</b-col>
						<b-col md="3">
							<b-form-group label="End Time"
		                                label-for="end_time">
								<b-form-input id="end_time"
											type="time"
											v-model="form.endTime"
											required
											placeholder="Enter end time">
								</b-form-input>
							</b-form-group>
						</b-col>
					</b-row>
				</b-col>
			</b-row>

			<div class="mt-20 d-flex justify-content-end">
				<b-button type="submit" variant="primary" class="uppercase">request swell data</b-button>
			</div>

		</b-form>

		<b-form @submit="onSubmitReport" v-show="showReportFields" class="my-20">

			<b-row>
				<b-col>
					<b-row>
						<b-col md=12 class="text-center swell-data mb-20">
							<b-row>
								<b-col>
									<b-row class="mb-20">
										<b-col>
											<h3>Swell</h3>
										</b-col>
									</b-row>
									<b-row>
										<b-col md=6 class="d-flex justify-content-center mb-30">
											<div class="compass">
												<div class="north">N</div>
												<div class="west">W</div>
												<div class="east">E</div>
												<div class="south">S</div>
												<div class="direction">
													<p>{{ this.swellData.buoys.average.angle }}&deg; {{ this.swellData.buoys.average.direction }}<span>{{ this.swellData.buoys.average.height }}ft @ {{ this.swellData.buoys.average.period }}s</span></p>
												</div>
												<div class="arrow"
													v-bind:class="this.swellData.buoys.average.direction.toLowerCase().trim()">
												</div>
											</div>
										</b-col>
										<!-- <b-col md=3 class="vertical-center">
											<font-awesome-icon :icon="icon" size="3x" rotation="270"/>
										</b-col> -->
										<b-col md=6 class="vertical-center mt-10">
											<b-row>
												<div>
													<p class="heading-label">Buoys</p>
												</div>
												<div class="buoy-data">
													<p class="ft-16 my-0"><span class="ft-bold">Start</span>: {{ this.swellData.buoys.start.height }}ft @ {{ this.swellData.buoys.start.period }}s - {{ this.swellData.buoys.start.angle }}&deg; {{ this.swellData.buoys.start.direction }}</p>
													<p class="ft-16 my-0"><span class="ft-bold">End</span>: {{ this.swellData.buoys.end.height }}ft @ {{ this.swellData.buoys.end.period }}s - {{ this.swellData.buoys.end.angle }}&deg; {{ this.swellData.buoys.end.direction }}</p>
												</div>
											</b-row>
											<b-row class="mt-20">
												<div>
													<p class="heading-label">Wind</p>
												</div>
												<div class="buoy-data">
													<p class="ft-16 my-0"><span class="ft-bold">Start</span>: {{ this.swellData.wind.start.speed }}mph {{ this.swellData.wind.start.direction }}</p>
													<p class="ft-16 my-0"><span class="ft-bold">End</span>: {{ this.swellData.wind.end.speed }}mph {{ this.swellData.wind.end.direction }}</p>
												</div>
											</b-row>
											<b-row class="mt-20">
												<div>
													<p class="heading-label">Tide</p>
												</div>
												<div class="buoy-data">
													<p class="ft-16 my-0"><span class="ft-bold">Start</span>: {{ this.swellData.tide.start }}ft</p>
													<p class="ft-16 my-0"><span class="ft-bold">End</span>: {{ this
													.swellData.tide.end }}ft</p>
													<p class="ft-16 my-0"><span class="ft-bold">Direction</span>: {{ this.swellData.tide.direction }}</p>
												</div>
											</b-row>
										</b-col>
									</b-row>
								</b-col>
							</b-row>
						</b-col>
					</b-row>
				</b-col>
			</b-row>
			
			<b-row>
				<b-col>
					<b-row class="text-center">
						<b-col class="form-section mb-10"><h3>Observations</h3></b-col>
					</b-row>
					<b-row>
						<b-col md="3">
							<b-form-group id=""
										label="Height (ft)"
										label-for="actualHeight">
								<b-form-input id="actualHeight"
											type="text"
											v-model="form.actualHeight"
											placeholder="3-5">
		                        </b-form-input>
							</b-form-group>
						</b-col>
						<b-col md="3">
							<b-form-group id=""
										label="Conditions"
										label-for="conditions">
		                        <model-select :options="conditions"
											v-model="form.conditions"
											placeholder='Select One'>
								</model-select>
							</b-form-group>
						</b-col>
						<b-col md="3">
							<b-form-group id=""
										label="Score"
										label-for="score">
								<b-form-select id="score"
											:options="ratings"
											v-model="form.score">
		                        </b-form-select>
							</b-form-group>
						</b-col>
						<b-col md="3">
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
				</b-col>
			</b-row>

			<div class="mt-20 d-flex justify-content-end">
				<b-button type="submit"
					variant="primary"
					class="uppercase">
					submit report
				</b-button>
			</div>
			
        </b-form>
    </b-container>
</template>

<script>
	import axios from 'axios';
	import { ModelSelect } from 'vue-search-select'
	import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
	import faLocationArrow from '@fortawesome/fontawesome-free-solid/faLocationArrow'

	window.moment = require('moment');


	export default {
		props: [
			'initialuserid',
			'initiallocations',
			'initialconditions',
		],
        data () {
    		return {
                form: {
	                date: moment().format('YYYY-MM-DD'),
	                startTime: '',
	                endTime: '',
	                location: null,
	                actualHeight: '',
	                conditions: null,
	                score: null,
	                notes: '',
	            },
	            userId: this.$props.initialuserid,
	            locations: this.$props.initiallocations,
	            conditions: this.$props.initialconditions,
	            ratings: [
		            { text: 'Select One', value: null },
	                { text: '1', value: '1' },
	                { text: '2', value: '2' },
	                { text: '3', value: '3' },
	                { text: '4', value: '4' },
	                { text: '5', value: '5' },
	                { text: '6', value: '6' },
	                { text: '7', value: '7' },
	                { text: '8', value: '8' },
	                { text: '9', value: '9' },
	                { text: '10', value: '10' },
	            ],
	            success: false,
	            error: false,
	            dismissSecs: 5,
				successDismissCountDown: 0,
				errorDismissCountDown: 0,
				showDismissibleAlert: false,
				showReportFields: false,

				swellData: {
					buoys: {
						start: {
							height: '',
							period: '',
							angle: '',
							direction: '',
						},
						end:  {
							height: '',
							period: '',
							angle: '',
							direction: '',
						},
						average: {
							height: '',
							period: '',
							angle: '',
							direction: '',
						}
					},
					wind: {
						start: {
							speed: '',
							direction: '',
						},
						end: {
							speed: '',
							direction: '',
						}
					},
					tide: {
						start: '',
						end: '',
						direction: '',
					}
				}
            }
        },
        methods: {
    		onSubmitRequest (e) {
                e.preventDefault();
                this.success = false;
                this.error = false;
            	axios.get(`/api/swell`, {
            	params: {
                	'user_id': this.userId,
                	'date': this.form.date,
                	'start_time': this.form.startTime,
                	'end_time': this.form.endTime,
                	'location_id': this.form.location,
            	}
                }).then(response => {
					this.setSwellValues(response.data.data);
					this.showReportFields = true;
				}).catch(error => {
					console.log(error);
					this.showAlert('error');
					this.error = true;
				})
            },
            onSubmitReport(e) {
            	e.preventDefault();
            	axios.post(`/api/reports`, {
                	'user_id': this.userId,
                	'date': this.form.date,

                	'start_time': this.form.startTime,
                	'end_time': this.form.endTime,

                	'location_id': this.form.location,

                	'start_swell_dir': this.swellData.buoys.start.direction,
					'start_swell_angle': this.swellData.buoys.start.angle,
					'start_swell_height': this.swellData.buoys.start.height,
					'start_swell_period': this.swellData.buoys.start.period,

					'end_swell_dir': this.swellData.buoys.end.direction,
					'end_swell_angle': this.swellData.buoys.end.angle,
					'end_swell_height': this.swellData.buoys.end.height,
					'end_swell_period': this.swellData.buoys.end.period,

					'start_wind_dir': this.swellData.wind.start.direction,
					'start_wind_speed': this.swellData.wind.start.speed,

					'end_wind_dir': this.swellData.wind.end.direction,
					'end_wind_speed': this.swellData.wind.end.speed,

					'tide_dir': this.swellData.tide.direction,
		            'start_tide_height': this.swellData.tide.start,
		            'end_tide_height': this.swellData.tide.end,

		            'actual_surf_height': this.form.actualHeight,
		            'condition_id': this.form.conditions,
		            'score': this.form.score,
		            'notes': this.form.notes,

                }).then(response => {
	                this.showAlert('success');
				}).catch(error => {
					console.log(error);
					this.showAlert('error');
					this.error = true;
				})
            },
			showAlert(type) {
				if (type === 'success') this.successDismissCountDown = this.dismissSecs;
				if (type === 'error') this.errorDismissCountDown = this.dismissSecs;
			},
			setSwellValues(data) {
				console.log(data);
				this.swellData.buoys.start.height = data.buoys.startBuoy.wave_height;
				this.swellData.buoys.start.period = data.buoys.startBuoy.dominant_period;
				this.swellData.buoys.start.angle = data.buoys.startBuoy.angle;
				this.swellData.buoys.start.direction = data.buoys.startBuoy.direction;

				this.swellData.buoys.end.height = data.buoys.endBuoy.wave_height;
				this.swellData.buoys.end.period = data.buoys.endBuoy.dominant_period;
				this.swellData.buoys.end.angle = data.buoys.endBuoy.angle;
				this.swellData.buoys.end.direction = data.buoys.endBuoy.direction;

				this.swellData.buoys.average.height = data.buoys.average.wave_height;
				this.swellData.buoys.average.period = data.buoys.average.period;
				this.swellData.buoys.average.angle = data.buoys.average.angle;
				this.swellData.buoys.average.direction = data.buoys.average.direction;

				this.swellData.wind.start.speed = data.wind.startWind.speed;
				this.swellData.wind.start.direction = data.wind.startWind.direction;

				this.swellData.wind.end.speed = data.wind.endWind.speed;
				this.swellData.wind.end.direction = data.wind.endWind.direction;

				this.swellData.tide.start = data.tides.tideAtStart;
				this.swellData.tide.end = data.tides.tideAtEnd;
				this.swellData.tide.direction = data.tides.dir;
			}
        },
        computed: {
			icon () {
				return faLocationArrow
			}
		},
        components: {
			ModelSelect,
			FontAwesomeIcon
	    }
	}
</script>
