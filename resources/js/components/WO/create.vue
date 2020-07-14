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
                    <h3 class="mb-0">Información de la Orden de Trabajo</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <div class="alert alert-danger fade show" role="alert" v-if="wo.errors.length > 0">
                        <a href="#" class="close" aria-label="close" @click="hideAlert()">&times;</a>
                        <div v-for="(error,i) in wo.errors" :key="i">
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
                                <label class="form-control-label" for="wonumber">Orden de Trabajo:</label>
                                <input type="text" class="form-control" id="wonumber" v-model="wo.wonumber" placeholder="" v-validate="'required'" data-vv-as="Orden de Trabajo" name="wonumber" 
                                    :class="{ 'is-invalid': submitted && errors.has('wonumber') }" />
                                <div v-if="submitted && errors.has('wonumber')" class="invalid-feedback">
                                    {{ errors.first("wonumber") }}
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="folio">Folio:</label>
                                <input type="text" class="form-control" id="folio" v-model="wo.folio" placeholder="" v-validate="'required'" data-vv-as="Folio" name="folio" 
                                    :class="{ 'is-invalid': submitted && errors.has('folio') }" />
                                <div v-if="submitted && errors.has('folio')" class="invalid-feedback">
                                    {{ errors.first("folio") }}
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="client">Cliente:</label>
                                <input type="text" class="form-control" id="client" v-model="wo.customer" placeholder="" v-validate="'required'" data-vv-as="Cliente" name="customer" 
                                    :class="{ 'is-invalid': submitted && errors.has('customer') }" />
                                <div v-if="submitted && errors.has('customer')" class="invalid-feedback">
                                    {{ errors.first("customer") }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="phone">Teléfono:</label>
                                <input type="text" class="form-control" id="phone" v-model="wo.phone" placeholder="" v-validate="'required'" data-vv-as="Teléfono" name="phone" 
                                    :class="{ 'is-invalid': submitted && errors.has('phone') }" />
                                <div v-if="submitted && errors.has('phone')" class="invalid-feedback">
                                    {{ errors.first("phone") }}
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="phone">Equipo:</label>
                                <multiselect v-model="wo.machine" :options="machines" :searchable="true" :close-on-select="true" :show-labels="false" placeholder=""
                                    v-validate="'required'" data-vv-as="Equipo" name="machine" 
                                        :class="{ 'is-invalid': submitted && errors.has('machine') }"></multiselect>
                                <div v-if="submitted && errors.has('machine')" class="invalid-feedback">
                                    {{ errors.first("machine") }}
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="date">Entrega:</label>
                                <multiselect v-model="wo.delivery" :options="deliveries" :searchable="true" :close-on-select="true" :show-labels="false" placeholder=""
                                    v-validate="'required'" data-vv-as="Entrega" name="delivery" 
                                        :class="{ 'is-invalid': submitted && errors.has('delivery') }"></multiselect>
                                <div v-if="submitted && errors.has('delivery')" class="invalid-feedback">
                                    {{ errors.first("delivery") }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="delivery_date">Fecha de Entrega:</label>
                                <!-- <date-picker v-model="wo.delivery_date" value-type="DD/MM/YYYY" format="DD/MM/YYYY" v-validate="'required'" data-vv-as="Fecha de Entrega" name="delivery_date" :class="{ 'is-invalid': submitted && errors.has('delivery_date') }">
                                    <div class="invalid-feedback" v-if="submitted && errors.has('delivery_date')">{{ errors.first("delivery_date") }}</div>
                                </date-picker> -->
                                <datepicker :format="'dd/MM/yyyy'" v-model="date" :bootstrap-styling="true" v-validate="'required'" data-vv-as="Fecha" 
                                        name="date" :class="{ 'is-invalid': submitted && errors.has('date') }" :disabled-dates="state.disabledDates"></datepicker>                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-12 text-right">
                            <button href="#" class="btn btn-sm btn-neutral" @click="addRow()">Nuevo Producto</button>
                            
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="" >
                            <table class="table table-flush needs-validation" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Equipo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(prod, index) in wo.wodetail" v-bind:key="index">
                                        <td>
                                            <input type="number" class="form-control" placeholder="Cantidad" v-model="prod.quantity" @change="updateSubtotal()" v-validate="'required'" data-vv-as="Cantidad" :id="'qty' + index" :name="'qty' + index" 
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
                                            <input type="number" class="form-control" placeholder="Precio" v-model="prod.price" @change="updateSubtotal()" v-validate="'required'" data-vv-as="Precio" :id="'price' + index" :name="'price' + index" 
                                                :class="{ 'is-invalid': submitted && errors.has('price' + index) }" />
                                            <div v-if="submitted && errors.has('price' + index)" class="invalid-feedback">
                                                {{ errors.first("price" + index) }}
                                            </div>
                                        </td>
                                        <td>
                                            <multiselect style="width: 90%" v-model="prod.machine" :options="machines" :searchable="true" :close-on-select="true" :show-labels="false" placeholder=""
                                                v-validate="'required'" data-vv-as="Equipo" name="machine" 
                                                    :class="{ 'is-invalid': submitted && errors.has('machine') }"></multiselect>
                                            <div v-if="submitted && errors.has('machine')" class="invalid-feedback">
                                                {{ errors.first("machine") }}
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <a href="#" class="btn btn-sm btn-danger" @click="deleteRow(index)">Quitar</a>
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
                                <input type="number" class="form-control" id="advance" v-model="wo.advance" @change="updateSubtotal()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="toPay">Por Pagar:</label>
                                <input type="text" class="form-control" id="toPay" v-model="wo.toPay" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="subtotal">Subtotal:</label>
                                <input type="text" class="form-control" id="subtotal" v-model="wo.subtotal" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="iva">I.V.A.:</label>
                                <input type="text" class="form-control" id="iva" v-model="wo.iva" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-9 col-md-3">
                            <div class="form-group">
                                <label class="form-control-label" for="total">Total:</label>
                                <input type="text" class="form-control" id="total" v-model="wo.total" readonly>
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
    var state = {
        disabledDates: {
            to: new Date(2020, 6, 13), // Disable all dates up to specific date   
        }
    }
    export default {		
        props: {
            title: '',
            id: ''
        },
    	data(){
    		return {
                format: 'dd/MM/yyyy',
                date: null,
				wo: {
					advance: '0.00',
					toPay: '0.00',
					subtotal: '0.00',
					iva: '0.00',
					total: '0.00',
					date: '',
					wonumber: '',
					folio: '',
					customer: '',
					phone: '',
                    delivery: '',
                    wodetail: [],
                    errors: []
				},    			
    			quantity: '',
    			description: '',
    			price: '',
                submitted: false,
                message: "",
                machines: [
                    'Xerox',
                    'Xuli',
                    'Infinity',
                    'Hp',
                    'Cnc',
                    'Laser',
                    'Sublimación',
                    'Serigrafía',
                    'UV'
                ],
                deliveries: [
                    'Domicilio',
                    'Mostrador',
                    'Instalación'
                ],
                state: {
                    disabledDates: {
                        to: new Date(), // Disable all dates up to specific date   
                    }
                },
                currentDate: null
            }            
    	},
    	methods: {
    		addRow(){
    			var row = {
    				quantity: '',
    				description: '',
                    price: '',
                    machine: 'Xerox'
    			};
    			this.wo.wodetail.push(row);
    		},
            cancel(){
                window.location.href = "/oc";
            },
    		deleteRow(index) {
				this.wo.wodetail.splice(index,1);
				this.updateSubtotal();
            },
            getWo(id){
                axios.get('/api/wo/' + id)
                    .then(response => {
                        this.wo = response.data;
                        this.wo.errors = [];
                    })
            },            
    		save(){
                this.submitted = true;
                if(this.date !== null){
                    this.wo.delivery_date = moment(this.date, 'DD/MM/YYYY').format('MM/DD/YYYY');
                }
                else{
                    this.ShowModalMessage('Ingrese una fecha de entrega', 1);
                    return;
                }
                
    			this.$validator.validate().then(valid => {
    				if (valid) {
                        if(this.wo.wodetail.length == 0){
                            this.wo.errors = "No se agregaron productos";
                            return;
                        }
                        this.showLoading();
    					this.wo.errors = [];
                        this.message = "";
						axios.post('/api/wo', this.wo)
						.then(response => {
							this.wo = {
                                errors: [],
                                wodetail: []
							}
                            this.submitted = false;
                            window.location.href = "/ordentrabajo";
                            this.stopLoading();
						}).catch(errors => {
                            this.submitted = false;
                            this.stopLoading();
                             if(typeof errors.response.data === 'object')
                                if(errors.response.data.errors != undefined)
                                    this.wo.errors = _.flatten(_.toArray(errors.response.data.errors))
                                else
                                    this.wo.errors = ['Algo salio mal!']
                            else
                                this.wo.errors = ['Algo salio mal!']
                            })
    				}
    			});
			},
			updateSubtotal(){
				let subtotal = 0;
				this.wo.wodetail.forEach(function(item) {
					if(!isNaN(parseFloat(item.price)) && isFinite(item.price) && !isNaN(parseFloat(item.quantity)) && isFinite(item.quantity)){
						subtotal += (parseFloat(item.price) * parseFloat(item.quantity));
					}
				});
				this.wo.subtotal = this.addCommas(subtotal);
				this.wo.iva = (subtotal * 1.16 - subtotal).toFixed(2);
				this.wo.total = (subtotal * 1.16).toFixed(2);
				if(!isNaN(parseFloat(this.wo.advance)) && isFinite(this.wo.advance)){
                    this.wo.toPay = ((subtotal * 1.16) - this.wo.advance).toFixed(2);
                }
            },
            addCommas(nStr) {
                nStr += '';
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            },
        },
    	mounted(){
            if(this.id > 0){
                this.getWo(this.id);
            }
			this.addRow();            
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
            });
            this.wo.date = this.date = moment().format('DD/MM/YYYY');
            this.currentDate = new Date();
            this.currentDate.setDate(this.currentDate.getDate() - 1);
            this.state.disabledDates.to = this.currentDate;
		},
    }
</script>