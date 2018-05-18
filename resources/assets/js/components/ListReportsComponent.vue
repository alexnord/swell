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
		            // see the options API
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
