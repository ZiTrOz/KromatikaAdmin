<template>
<div>
	<create-oc-component v-if="component == 'create-oc'" :title="title"></create-oc-component>
  <create-oc-component v-if="component == 'edit-oc'" :title="title" :id="id" ></create-oc-component>
  <index-oc-component v-if="component == 'index-oc'"></index-oc-component>
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