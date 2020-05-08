<template>
    <div id="content">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">{{ title }}</h6>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <button class="btn btn btn-success" @click="save()">Confirmar Entrega</button>
                            <button class="btn btn btn-info" @click="cancel()">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="card mb-4">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Información de la Orden de Compra</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div class="alert alert-danger fade show" role="alert" v-if="po.errors.length > 0">
                        <a href="#" class="close" aria-label="close" @click="hideAlert()">&times;</a>
                        <div v-for="(error,i) in po.errors" :key="i">
                            <label>{{ error }}</label><br/>
                        </div>    
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="message.length > 0">
                        <span class="alert-inner--icon">
                            <i class="ni ni-like-2"></i></span>
                        <span class="alert-inner--text">{{message}}</span>
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Form groups used in grid -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="ponumber">Orden de Compra:</label>
                                <input type="text" class="form-control form-control-sm" id="ponumber" v-model="po.ponumber" readonly />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="folio">Folio:</label>
                                <input type="text" class="form-control form-control-sm" id="folio" v-model="po.folio" readonly/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="delivery_date">Fecha de Entrega:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                    <input class="form-control datepicker" placeholder="Seleccione la fecha" v-model="po.delivery_date" type="text" v-validate="'required'" data-vv-as="Fecha de Entrega" 
                                        name="delivery_date" :class="{ 'is-invalid': submitted && errors.has('delivery_date') }" >
                                    <div v-if="submitted && errors.has('delivery_date')" class="invalid-feedback">
                                        {{ errors.first("delivery_date") }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="client">Cliente:</label>
                                <input type="text" class="form-control form-control-sm" id="client" v-model="po.customer" readonly/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="phone">Tel:</label>
                                <input type="text" class="form-control form-control-sm" id="phone" v-model="po.phone" readonly />                               
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="date">Entrega:</label>
                                <select class="form-control" data-toggle="select" v-model="po.delivery" data-minimum-results-for-search="Infinity">
                                    <option>Mostrador</option>
                                    <option>Domicilio</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive py-4" >
                            <table class="table table-flush needs-validation" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Precio</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr v-for="(prod, index) in po.podetail" v-bind:key="index">
                                        <td>
                                            <label class="form-control-label">{{ prod.quantity }}</label>
                                        </td>
                                        <td>
                                            <label class="form-control-label">{{ prod.description }}</label>
                                        </td>
                                        <td>
                                            <label class="form-control-label">{{ prod.price }}</label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="advance">Anticipo:</label>
                                <input type="text" class="form-control form-control-sm" id="advance" v-model="po.advance" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="toPay">Por Pagar:</label>
                                <input type="text" class="form-control form-control-sm" id="toPay" v-model="po.toPay" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="subtotal">Subtotal:</label>
                                <input type="text" class="form-control form-control-sm" id="subtotal" v-model="po.subtotal" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="iva">I.V.A.:</label>
                                <input type="text" class="form-control form-control-sm" id="iva" v-model="po.iva" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-9 col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="total">Total:</label>
                                <input type="text" class="form-control form-control-sm" id="total" v-model="po.total" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer-component></footer-component>
        </div>
    </div>
</template>
<script>
    export default {		
        props: {
            title: '',
            id: ''
        },
    	data(){
    		return {
				po: {
					advance: '0.00',
					toPay: '0.00',
					subtotal: '0.00',
					iva: '0.00',
					total: '0.00',
					date: '',
					ponumber: '',
					folio: '',
					customer: '',
					phone: '',
                    delivery: 'Mostrador',
                    podetail: [],
                    delivey_date: '',
                    errors: []
				},    
                submitted: false,
                message: ''
    		}
    	},
    	methods: {    
            cancel(){
                window.location.href = "/oc";
            },	
            getPo(id){
                axios.get('/api/po/' + id)
                    .then(response => {
                        this.po = response.data;
                        this.po.delivery_date = moment().format('DD/MM/YYYY');
                        this.po.errors = [];
                    })
            },
            hideAlert(){
                $(".alert").hide();
            },
    		save(){
    			this.submitted = true;
    			this.$validator.validate().then(valid => {
    				if (valid) {
                        if(this.po.podetail.length == 0){
                            this.po.errors = "No se agregaron productos";
                            return;
                        }
                        this.showLoading();
    					this.po.errors = [];
                        this.message = "";
                        this.po.delivery_date = moment(this.delivery_date);
						axios.post('/po/delivery/' + this.po.id, this.po)
						.then(response => {
							this.po = {
                                errors: [],
                                podetail: []
							}
                            this.submitted = false;
                            window.location.href = "/oc";
                            this.stopLoading();
						}).catch(errors => {
                            this.stopLoading();
                            this.submitted = false;
                             if(typeof errors.response.data === 'object')
                                if(errors.response.data.errors != undefined)
                                    this.po.errors = _.flatten(_.toArray(errors.response.data.errors))
                                else
                                    this.po.errors = ['Algo salio mal!']
                            else
                                this.po.errors = ['Algo salio mal!']
                            })
    				}
    			});
			},
    	},
    	mounted(){
            if(this.id > 0){
                this.getPo(this.id);
            }   
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
            }); 
            this.po.delivery_date = moment().format('DD/MM/YYYY');
		},
    }
</script>