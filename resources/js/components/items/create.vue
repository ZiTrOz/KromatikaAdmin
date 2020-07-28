<template lang="pug">
#content
    .header.bg-primary.pb-6
        .container-fluid
            .header-body
                .row.align-items-center.py-4
                    .col-lg-6.col-7
                        h6.h2.text-white.d-inline-block.mb-0 {{ title }}
                    .col-lg-6.col-5.text-right
                        button.btn.btn.btn-success(@click="save('item')") Guardar
                        button.btn.btn.btn-info Cancelar
    .container-fluid.mt--6
        .card.mb-4       
            .card-header
                h3.mb-0 Información del Artículo
            .card-body
                .alert.alert-danger.fade.show(role='alert', v-if='error.length > 0')
                    a.close(href='#', aria-label='close', @click='hideAlert()') &times;
                    div(v-for='(e,i) in error', :key='i')
                        label {{ e }}
                        br
                .alert.alert-success.alert-dismissible.fade.show(role='alert', v-if='message.length > 0')
                    span.alert-inner--icon
                        i.ni.ni-like-2
                    span.alert-inner--text {{ message }}
                    button.close(type='button', data-dismiss='alert', aria-label='Close')
                        span(aria-hidden='true') &times;
                .row
                    .col-md-6
                        .form-group
                            label.form-control-label(for='code') Clave:
                            input#code.form-control(type='text', v-model='item.code', placeholder='', data-vv-scope='item', v-validate="'required'", data-vv-as='Clave', name='code', :class="{ 'is-invalid': submitted && errors.has('item.code') }")
                            .invalid-feedback(v-if="submitted && errors.has('item.code')")
                                | {{ errors.first('item.code') }}
                    .col-md-6
                        .form-group
                            label.form-control-label(for='item') Artículo:
                            input#item.form-control(type='text', v-model='item.item', placeholder='', data-vv-scope='item', v-validate="'required'", data-vv-as='Material', name='item', :class="{ 'is-invalid': submitted && errors.has('item.item') }")
                            .invalid-feedback(v-if="submitted && errors.has('item.item')")
                                | {{ errors.first('item.item') }}
                .row
                    .col-md-6
                        .form-group
                            label.form-control-label(for='uom') UOM:
                            multiselect(v-model="item.uom" :options="uoms" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="" name="uom")
                    .col-md-6
                        .form-group
                            label.form-control-label(for='color') Color:
                            input#color.form-control(type='text', v-model='item.color', placeholder='', data-vv-scope='item', v-validate="'required'", data-vv-as='Color', name='color', :class="{ 'is-invalid': submitted && errors.has('item.color') }")
                            .invalid-feedback(v-if="submitted && errors.has('item.color')")
                                | {{ errors.first('item.color') }}
                .row
                    .col-md-6
                        .form-group
                            label.form-control-label(for='description') Descripción:
                            input#description.form-control(type='text', v-model='item.description', placeholder='',data-vv-scope='item',  v-validate="'required'", data-vv-as='Descripción', name='description', :class="{ 'is-invalid': submitted && errors.has('item.description') }")
                            .invalid-feedback(v-if="submitted && errors.has('item.description')")
                                | {{ errors.first('item.description') }}
                    .col-md-6
                        .form-group
                            label.form-control-label(for='cost') Costo:
                            input#cost.form-control(type='text', v-model='item.cost', placeholder='',data-vv-scope='item',  v-validate="'required'", data-vv-as='Costo', name='cost', :class="{ 'is-invalid': submitted && errors.has('item.cost') }")
                            .invalid-feedback(v-if="submitted && errors.has('item.cost')")
                                | {{ errors.first('item.cost') }}

                .row
                    .col-md-4
                        .form-group
                            label.form-control-label(for='department') Departamento:
                            multiselect(v-model="item.department" :options="departments" :searchable="true" :close-on-select="true" :show-labels="false" placeholder=""
                                name="machine")
                            
                .row                                           
                    .col-md-4
                        .form-group
                            label.form-control-label(for='supplier_id') Proveedor:
                            multiselect(v-model="item.supplier",:options="suppliers", label="name", track-by="id", :searchable="true",:close-on-select="true",:show-labels="false", placeholder="")
                                       
                    .col-auto(style='margin-top: 35px;')
                        label.form-control-label 
                        button.btn.btn-sm.btn-danger(type='button', @click='openModal()') Nuevo Proveedor
            
        
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
                                label.form-control-supplier(for='supplier') Nombre del Proveedor:
                                input#supplier.form-control(type='text', v-model='supplier.name', placeholder='', v-validate="'required'", data-vv-scope='supplier', data-vv-as='Proveedor', name='name', :class="{ 'is-invalid': submitted && errors.has('supplier.name') }")
                                .invalid-feedback(v-if="submitted && errors.has('supplier.name')")
                                    | {{ errors.first('supplier.name') }}                         
                    .modal-footer
                        button.btn.btn-secondary(type='button', data-dismiss='modal') Cancelar
                        button.btn.btn-primary(type='button', @click="saveSupplier('supplier')") Guardar Proveedor
        // Footer
        footer-component
</template>
<script>
export default {
    props: {
            title: '',
            id: ''
        },
    	data(){
    		return {
				item: {					
                    item: '',
                    color: '',
                    user_id: 0,
                    supplier_id: '',
                    description: '',
                    id: 0,
                    supplier: null,
                    uom: '',
                    deparment: '',
                    cost: 0,
				},    			
                submitted: false,
                message: "", 
                supplier: {
                    name: ''
                },
                suppliers: [],
                valid: false,
                error: [],
                departments: [
                    'Acabados',   
                    'Antiestres', 
                    'Diseño',
                    'Producción',
                ],
                uoms: [
                    'Metros',   
                    'Pieza', 
                    'Kilos',
                    'N/A',
                ],
    		}
    	},
    	methods: { 
            openModal() {
                $('#supplierModal').modal('show');
            },
            getItem(id){
                axios.get('/api/item/' + id)
                    .then(response => {
                        this.item = response.data;
                })
            },
            getSuppliers(id){
                this.showLoading();
                axios.get('/api/supplier')
                    .then(response => {
                        this.suppliers = response.data;
                        this.stopLoading();
                })
            },
    		save(scope){                
                this.submitted = true;
                this.valid = true;
                this.item.supplier_id = this.item.supplier.id;
                if(this.item.supplier_id === null){
                    this.ShowMessagePopup('Seleccione un proveedor', 1)
                    this.valid = false;
                }
    			this.$validator.validateAll(scope).then(valid => {
    				if (valid && this.valid) {                        
                                               
                        if(this.item.id === 0){
                            this.create(this.item);
                        }
                        else{
                            this.update(this.item);
                        }
                    }
    			});
            },
            saveSupplier(scope){
                this.submitted = true;
                this.$validator.validateAll(scope).then(valid => {
    				if (valid) {                        
                        this.showLoading();
                        this.message = "";
						axios.post('/api/supplier', this.supplier)
						.then(response => {
							this.supplier = [];
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
    			});
            },
            create(item){
                this.showLoading();
                    this.error = [];
                    this.message = "";
                    axios.post('/api/item', this.item)
                    .then(response => {
                        this.item = [];
                        this.submitted = false;
                        this.stopLoading();
                        window.location.href = "/articulos";
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
            },
            update(item){
                this.showLoading();
                this.error = [];
                this.message = "";
                axios.put('/api/item/' + this.item.id, this.item)
                .then(response => {
                    this.item = { }
                    this.submitted = false;
                    this.stopLoading();
                    window.location.href = "/articulos";
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
            },
    	},
    	mounted(){
            if(this.id > 0){
                this.getItem(this.id);
            }
            this.getSuppliers();            
		},
}
</script>