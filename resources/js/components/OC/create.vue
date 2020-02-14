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
                            <button class="btn btn btn-success" @click="save()">Guardar</button>
                            <button class="btn btn btn-info">Cancelar</button>
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
                                <input type="text" class="form-control" id="ponumber" v-model="po.ponumber" placeholder="" v-validate="'required'" data-vv-as="Orden de Compra" name="ponumber" 
                                    :class="{ 'is-invalid': submitted && errors.has('ponumber') }" />
                                <div v-if="submitted && errors.has('ponumber')" class="invalid-feedback">
                                    {{ errors.first("ponumber") }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="folio">Folio:</label>
                                <input type="text" class="form-control" id="folio" v-model="po.folio" placeholder="" v-validate="'required'" data-vv-as="Folio" name="folio" 
                                    :class="{ 'is-invalid': submitted && errors.has('folio') }" />
                                <div v-if="submitted && errors.has('folio')" class="invalid-feedback">
                                    {{ errors.first("folio") }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="date">Fecha:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                    <!-- <datepicker v-model="po.date" format="dd/MM/yyyy" input-class="form-control" calendar-class="datepicker"></datepicker> -->
                                    <input class="form-control datepicker" placeholder="Select date" v-model="po.date" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="client">Cliente:</label>
                                <input type="text" class="form-control" id="client" v-model="po.customer" placeholder="" v-validate="'required'" data-vv-as="Cliente" name="customer" 
                                    :class="{ 'is-invalid': submitted && errors.has('customer') }" />
                                <div v-if="submitted && errors.has('customer')" class="invalid-feedback">
                                    {{ errors.first("customer") }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="phone">Tel:</label>
                                <input type="text" class="form-control" id="phone" v-model="po.phone" placeholder="" v-validate="'required'" data-vv-as="Teléfono" name="phone" 
                                    :class="{ 'is-invalid': submitted && errors.has('phone') }" />
                                <div v-if="submitted && errors.has('phone')" class="invalid-feedback">
                                    {{ errors.first("phone") }}
                                </div>
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
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-12 text-right">
                            <button href="#" class="btn btn-sm btn-neutral" @click="addRow()">Nuevo Producto</button>
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(prod, index) in po.podetail" v-bind:key="index">
                                        <td>
                                            <input type="text" class="form-control" placeholder="Cantidad" v-model="prod.quantity" @change="updateSubtotal()" v-validate="'required'" data-vv-as="Cantidad" :id="'qty' + index" :name="'qty' + index" 
                                                :class="{ 'is-invalid': submitted && errors.has('qty' + index) }" />
                                            <div v-if="submitted && errors.has('qty' + index)" class="invalid-feedback">
                                                {{ errors.first("qty" + index) }}
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Descripción" v-model="prod.description" v-validate="'required'" data-vv-as="Descripción" :id="'desc' + index" :name="'desc' + index" 
                                                :class="{ 'is-invalid': submitted && errors.has('desc' + index) }" />
                                            <div v-if="submitted && errors.has('desc' + index)" class="invalid-feedback">
                                                {{ errors.first("desc" + index) }}
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Precio" v-model="prod.price" @change="updateSubtotal()" v-validate="'required'" data-vv-as="Precio" :id="'price' + index" :name="'price' + index" 
                                                :class="{ 'is-invalid': submitted && errors.has('price' + index) }" />
                                            <div v-if="submitted && errors.has('price' + index)" class="invalid-feedback">
                                                {{ errors.first("price" + index) }}
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;"><a href="#" class="btn btn-sm btn-danger" @click="deleteRow(index)">Quitar</a></td>
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
                                <input type="text" class="form-control" id="advance" v-model="po.advance" @change="updateSubtotal()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="toPay">Por Pagar:</label>
                                <input type="text" class="form-control" id="toPay" v-model="po.toPay" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="subtotal">Subtotal:</label>
                                <input type="text" class="form-control" id="subtotal" v-model="po.subtotal" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="iva">I.V.A.:</label>
                                <input type="text" class="form-control" id="iva" v-model="po.iva" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-9 col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="total">Total:</label>
                                <input type="text" class="form-control" id="total" v-model="po.total" readonly>
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
                    errors: []
				},    			
    			quantity: '',
    			description: '',
    			price: '',
                submitted: false,
                message: "",
    		}
    	},
    	methods: {
    		addRow(){
    			var row = {
    				quantity: '',
    				description: '',
    				price: ''
    			};
    			this.po.podetail.push(row);
    		},
    		deleteRow(index) {
				this.po.podetail.splice(index,1);
				this.updateSubtotal();
            },
            getPo(id){
                axios.get('/api/po/' + id)
                    .then(response => {
                        this.po = response.data;
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
                        //$("#content").loading();
    					this.po.errors = [];
						this.message = "";
						axios.post('/api/po', this.po)
						.then(response => {
							this.po = {
                                errors: [],
                                podetail: []
							}
                            this.submitted = false;
                            window.location.href = "/oc/editar";
                            //$("#content").loading('stop');
						}).catch(errors => {
                            this.submitted = false;
                            //$("#content").loading('stop');
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
			updateSubtotal(){
				let subtotal = 0;
				this.po.podetail.forEach(function(item) {
					if(!isNaN(parseFloat(item.price)) && isFinite(item.price) && !isNaN(parseFloat(item.quantity)) && isFinite(item.quantity)){
						subtotal += (parseFloat(item.price) * parseFloat(item.quantity));
					}
				});
				this.po.subtotal = (subtotal).toFixed(2);
				this.po.iva = (subtotal * 1.16 - subtotal).toFixed(2)
				this.po.total = (subtotal * 1.16).toFixed(2);
				if(!isNaN(parseFloat(this.po.advance)) && isFinite(this.po.advance)){
					this.po.toPay = ((subtotal * 1.16) - this.po.advance).toFixed(2);
				}
			}
    	},
    	mounted(){
            if(this.id > 0){
                this.getPo(this.id);
            }
			this.addRow();            
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
            });
            this.po.date = moment().format('DD/MM/YYYY');
		},
    }
</script>