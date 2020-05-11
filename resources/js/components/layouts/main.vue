<template>
<div>
	<create-wo-component v-if="component == 'create-wo'" :title="title"></create-wo-component>
  <create-wo-component v-if="component == 'edit-wo'" :title="title" :id="id" ></create-wo-component>
  <delivery-wo-component v-if="component == 'delivery-wo'" :title="title" :id="id" ></delivery-wo-component>
  <index-wo-component v-if="component == 'index-wo'"></index-wo-component>
  <detail-wo-component v-if="component == 'detail-wo'" :title="title" :id="id" ></detail-wo-component>

  <locations-index v-if="component == 'locations-index'" :title="title" :id="id" ></locations-index>
  <transactions-index v-if="component == 'transactions-index'" :title="title" :id="id" ></transactions-index>
  <inventory-index v-if="component == 'inventory-index'" :title="title" :id="id" ></inventory-index>
</div>
</template>
<script>
export default{
		props: {
			title: '',
      component: '',
      id: ''
    },
    data(){
			return {
				
			}
    },
        methods: {
            
        },
    mounted(){
		}
  }
</script>