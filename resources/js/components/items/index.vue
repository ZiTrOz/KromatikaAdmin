<template lang="pug">
div
    .header.bg-primary.pb-6
        .container-fluid
            .header-body
                .row.align-items-center.py-4
                    .col-lg-6.col-7
                        h6.h2.text-white.d-inline-block.mb-0 {{ title }}
                    .col-lg-6.col-5.text-right
                        button.btn.btn-sm.btn-defaultcomposer require laravel/passport(@click='newItem()') Nuevo Articulo
    .container-fluid.mt--6
        .card.mb-4
            .card-header
                h3.mb0 Articulos
            .card-body
                .table-responsive.py-4
                    table#items.table.align-items-center.table-flush.table-hover
                        thead.thead-light
                            tr
                                th Clave
                                th Artículo
                                th Color                                
                                th Descripción
                                th Proveedor
                                th Departamento
                                th Acciones
                        tbody
                            tr(v-if='items.length > 0' v-for='(item, i) in items', :key='i')
                                td {{ item.code }}
                                td {{ item.item }}
                                td {{ item.color }}
                                td {{ item.description }}
                                td {{ item.supplier.name }}
                                td {{ item.department }}
                                td
                                    i.fas.fa-edit(title='Editar', @click='editItem(item)')
</template>
<script>
export default {
    props: {
            title: '',
            id: '',
        },
    	data(){
    		return {
				item: {					
                    Name: '',
                    Description: '',
                    id: 0,                  
                    errors: []
				},    			
                submitted: false,
                message: "",
                items: []         
    		}
    	},
    	methods: { 
            newItem() {
                window.location.href = "/articulo/crear";
            },
            editItem(item) {
                window.location.href = "/articulo/editar/" + item.id;
            },
            getItems(){
                this.showLoading();
                axios.get('/api/item')
                    .then(response => {
                        this.items = response.data;
                        this.mytable();
                        this.$forceUpdate();
                        this.stopLoading();
                })
            },
            getItem(id){
                axios.get('/api/item' + id)
                    .then(response => {
                        this.item = response.data;
                        this.item.errors = [];
                })
            },
            mytable(){
                $(function() {
                    $('#items').DataTable({
                        searching: false,
                        bLengthChange: false,
                        bFilter: false,
                        bInfo: false,
                        bAutoWidth: false,
                        "language": {
                            "emptyTable": "No se encontraron registros",
                            "zeroRecords": "No se encontraron registros"
                        },     
                        "drawCallback": function( settings ) {
                            $('.pagination .previous .page-link').html('<i class="fas fa-angle-left"></i>');
                            $('.pagination .next .page-link').html('<i class="fas fa-angle-right"></i>'); 
                        }   
                    });
                });   
            },
        },
        created: function(){
            this.getItems();
        },
    	mounted(){
            if(this.id > 0){
                this.getItem(this.id);
            }
            
		},
}
</script>