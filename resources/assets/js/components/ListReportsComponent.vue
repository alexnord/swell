<template>
	<b-container fluid id="create-form">
		
		<b-row v-if="fullList">
			<b-col>
				<v-client-table 
					:data="tableData" 
					:columns="columns" 
					:options="options"
					@row-click="onRowClick">
				</v-client-table>
			</b-col>
		</b-row>

		<b-row v-if="!fullList">
			<b-col>
				<div>
					<h1>{{ singleData.id }}</h1>
				</div>
			</b-col>
		</b-row>
		
    </b-container>
</template>

<script>
	import axios from 'axios';
	import { ClientTable, Event } from 'vue-tables-2';
	import './styles.scss';

	Vue.use(ClientTable);

	export default {
		props: [
			'initialreports',
		],
        data () {
    		return {
    			columns: [
	    			'id',
	    			'date',
    				'spot',
    				'angle',
    				'height',
    				'tide',
    				'wind',
    				'conditions',
    				'score',
    			],
		        tableData: this.$props.initialreports,
		        options: {
		            sortIcon: {
		            	base:'glyphicon',
		            	up:'glyphicon-chevron-up',
		            	down:'glyphicon-chevron-down',
		            	is:'glyphicon-sort' 
		            },
		            columnsDisplay: {
		            	'date': 'min_desktop',
		            	'tide': 'min_tablet',
		            	'wind': 'min_tabletL',
		            	'conditions': 'min_tabletL',
		            }
		        },
		        templates: {

		        },
	            reports: this.$props.initialreports,
	            fullList: true,
	            singleData: null,
            }
        },
        methods: {
    		onRowClick(e) {
    			axios.get(`/api/reports/${e.row.id}`)
				.then(response => {
					this.showRecord(response.data);
				}).catch(error => {
					console.log(error);
				})
            },
            showRecord(data) {
            	console.log(data);
            	this.fullList = false;
            	this.singleData = data;
            }
        },

	}
</script>
