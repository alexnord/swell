<template>
	<b-container fluid id="create-form">
		<b-row>
			<b-col>
				<v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table>
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
	            reports: this.$props.initialreports,
	            show: true
            }
        },
        methods: {
    		onSubmit (evt) {
                evt.preventDefault();
            },
        },
	}
</script>
