<template lang="pug">
div
    .header.bg-primary.pb-6
        .container-fluid
            .header-body
                .row.align-items-center.py-4
                    .col-lg-6.col-7
                        h6.h2.text-white.d-inline-block.mb-0 {{title}}
                    .col-lg-6.col-5.text-right
                        button.btn.btn-sm.btn-primary(@click='newSupplier()') Nuevo Proveedor
    .container-fluid.mt--6
        .card.mb-4
            .card-header
                h3.mb0 Proveedores Registrados
            .card-body
                .table-responsive.py-4
                    table#suppliers.table.align-items-center.table-flush.table-hover
                        thead.thead-light
                            tr
                                th Nombre
                                th Acciones
                        tbody
                            tr(v-for='(supplier, i) in suppliers', :key='i')
                                td {{ supplier.name }}
                                td
                                    i.fas.fa-edit(title='Editar', @click='editSupplier(supplier)')


    #supplierModal.modal.fade(tabindex='-1', role='dialog', aria-labelledby='supplierModalLabel', aria-hidden='true')
        .modal-dialog.modal-dialog-centered(role='document')
            .modal-content
                .modal-header(style="padding-botton: 0px;")
                    h5#exampleModalLabel.modal-title Nuevo Proveedor
                    button.close(type='button', data-dismiss='modal', aria-label='Close')
                        span(aria-hidden='true') &times;
                .modal-body(style="padding-top: 0px;")
                    .row
                        .col-md-12
                            .form-group
                            label.form-control-supplier(for='name') Nombre del Proveedor:
                            input#name.form-control(type='text', v-model='supplier.name', placeholder='', v-validate="'required'", data-vv-scope='supplier', data-vv-as='Proveedor', name='name', :class="{ 'is-invalid': submitted && errors.has('supplier.name') }")
                            .invalid-feedback(v-if="submitted && errors.has('supplier.name')")
                                | {{ errors.first('supplier.name') }}                     
                .modal-footer
                    button.btn.btn-secondary(type='button', data-dismiss='modal') Cancelar
                    button.btn.btn-primary(type='button', @click="saveSupplier('supplier')") Guardar Proveedor
</template>
<script>
export default {
    props: {
            title: '',
            id: '',
        },
    	data(){
    		return {
				supplier: {					
                    name: '',
                    id: 0,       
				},    			
                submitted: false,
                message: "",
                suppliers: [],
                error: []
    		}
    	},
    	methods: { 
            newSupplier() {
                this.supplier.Id = 0;
                $('#supplierModal').modal('show');
            },
            editsupplier(supplier) {
                this.supplier = supplier;
                console.log(this.supplier);
                $('#supplierModal').modal('show');
            },
            getSuppliers(){
                this.showLoading();
                axios.get('/api/supplier')
                    .then(response => {
                        this.suppliers = response.data;
                        this.error = [];
                        this.mytable();
                        this.$forceUpdate();
                        this.stopLoading();
                })
            },
            getSupplier(id){
                this.showLoading();
                axios.get('/api/supplier/' + id)
                    .then(response => {
                        this.supplier = response.data;
                        this.error = [];                        
                        this.$forceUpdate();
                        this.stopLoading();
                })
            },
    		saveSupplier(scope){
                this.submitted = true;
                this.$validator.validateAll(scope).then(valid => {
    				if (valid) {                        
                        this.showLoading();
    					this.supplier.errors = [];
                        this.message = "";
                        if(this.supplier.Id === 0){
                            axios.post('/api/supplier', this.supplier)
                            .then(response => {
                                this.supplier = { }
                                $('#supplierModal').modal('hide')
                                this.submitted = false;
                                this.suppliers = response.data;
                                this.stopLoading();
                            }).catch(errors => {
                                this.submitted = false;
                                this.stopLoading();
                                if(typeof errors.response.data === 'object')
                                    if(errors.response.data.errors != undefined)
                                        this.error = _.flatten(_.toArray(errors.response.data.errors))
                                    else
                                        this.error = ['Algo salio mal!']
                                else
                                    this.error = ['Algo salio mal!']
                                })
                                this.$forceUpdate();
                                this.stopLoading();
                                $('#supplierModal').modal('hide');
                        }
                        else{
                            axios.put('/api/supplier/' + this.supplier.id, this.supplier)
                            .then(response => {
                                this.supplier = {};
                                $('#supplierModal').modal('hide')
                                this.submitted = false;
                                this.suppliers = response.data;
                                this.stopLoading();
                            }).catch(errors => {
                                this.submitted = false;
                                this.stopLoading();
                                if(typeof errors.response.data === 'object')
                                    if(errors.response.data.errors != undefined)
                                        this.error = _.flatten(_.toArray(errors.response.data.errors))
                                    else
                                        this.error = ['Algo salio mal!']
                                else
                                    this.error = ['Algo salio mal!']
                                })
                                this.$forceUpdate();
                                this.stopLoading();
                                $('#supplierModal').modal('hide');
                        }
						
                    }
    			});
            },
            mytable(){
                $(function() {
                    $('#suppliers').DataTable({
                        searching: true,
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
            }
    	},
    	mounted(){
            if(this.id > 0){
                this.getSupplier(this.id);
            }
            this.getSuppliers();
		},
}
</script>