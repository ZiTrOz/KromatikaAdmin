<template>
<div>
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Movimientos de Almacén</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <button class="btn btn-sm btn-default" @click="newMov()">Nuevo Movimiento</button>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="date">Almacén:</label>
                            <multiselect v-model="warehouse" :options="warehouses" :searchable="true" :close-on-select="true" :show-labels="false"></multiselect>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="date">Movimiento:</label>
                            <multiselect v-model="movement" :options="movements" :searchable="true" :close-on-select="true" :show-labels="false"></multiselect>
                        </div>
                    </div>
                </div>
                <div class="table-responsive py-4">                        
                    <table class="table table-flush" id="movs">
                        <thead class="thead-light">
                            <tr>
                                <th>Almacen</th>
                                <th>Movimiento</th>
                                <th>Codigo</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(t, i) in transactions" :key="i">
                                
                                <td>{{ t.wonumber }}</td>
                                <td>{{ wo.delivery_date | moment("DD/MM/YYYY") }}</td>
                                <td>{{ (wo.total).toFixed(2) }}</td>
                                <td>{{ wo.status }}</td>
                                <td>
                                    <i class="fas fa-eye" title="Ver Detalle" @click="viewDetail(wo)"></i>
                                    <i class="fas fa-edit" title="Editar" @click="editWo(wo)"></i>
                                    <i :class="{'fas fa-shipping-fast' : wo.status === 'Por Entregar'}" title="Entregar" @click="deliveryWo(wo)"></i>
                                    <i :class="{'fas fa-check' : wo.status === 'Entregado'}" title="Entregado"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-botton: 0px;">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Transacción</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                <div class="modal-body" style="padding-top: 0px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="location">Almacén</label>
                                <multiselect v-model="transaction.warehouse" :options="warehouses" @close="changeLocations()" :searchable="true" :close-on-select="true" :show-labels="false" placeholder=""
                                    v-validate="'required'" data-vv-as="Almacén" name="warehouse" 
                                        :class="{ 'is-invalid': submitted && errors.has('warehouse') }"></multiselect>
                                <div v-if="submitted && errors.has('warehouse')" class="invalid-feedback">
                                    {{ errors.first("warehouse") }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="location">Movimiento</label>
                                <multiselect v-model="transaction.movement" :options="movements" :searchable="true" :close-on-select="true" :show-labels="false" placeholder=""
                                    v-validate="'required'" data-vv-as="Movimiento" name="movement" 
                                        :class="{ 'is-invalid': submitted && errors.has('movement') }"></multiselect>
                                <div v-if="submitted && errors.has('movement')" class="invalid-feedback">
                                    {{ errors.first("movement") }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div v-if="transaction.movement == 'Interno'" class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="from">De la Ubicación:</label>
                                <multiselect v-model="transaction.from" :options="options" label='location' :searchable="true" :close-on-select="true" :show-labels="false"></multiselect>
                                <div class="invalid-feedback" v-if="submitted &amp;&amp; errors.has('transaction.from')">{{ errors.first('transaction.from') }}</div>
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="to">A la Ubicación:</label>
                                <multiselect v-model="transaction.to" :options="options" label='location' :searchable="true" :close-on-select="true" :show-labels="false"></multiselect>
                                <div class="invalid-feedback" v-if="submitted &amp;&amp; errors.has('transaction.to')">{{ errors.first('transaction.location') }}</div>
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="item">Material:</label>
                                <input class="form-control" id="item" type="text" v-model="transaction.item" placeholder="" v-validate="'required'" data-vv-scope="transaction" data-vv-as="Material"
                                    name="item" :class="{ 'is-invalid': submitted &amp;&amp; errors.has('transaction.item') }" />
                                <div class="invalid-feedback" v-if="submitted &amp;&amp; errors.has('transaction.item')">{{ errors.first('transaction.item') }}</div>
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="code">Codigo:</label>
                                <input class="form-control" id="code" type="text" v-model="transaction.code" placeholder="" v-validate="'required'" data-vv-scope="transaction" data-vv-as="Codigo"
                                    name="code" :class="{ 'is-invalid': submitted &amp;&amp; errors.has('transaction.code') }" />
                                <div class="invalid-feedback" v-if="submitted &amp;&amp; errors.has('transaction.code')">{{ errors.first('transaction.code') }}</div>
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="quantity">Cantidad:</label>
                                <input class="form-control" id="quantity" type="text" v-model="transaction.quantity" placeholder="" v-validate="'required'" data-vv-scope="transaction" data-vv-as="Cantidad"
                                    name="quantity" :class="{ 'is-invalid': submitted &amp;&amp; errors.has('transaction.quantity') }" />
                                <div class="invalid-feedback" v-if="submitted &amp;&amp; errors.has('transaction.quantity')">{{ errors.first('transaction.quantity') }}</div>
                            </div>                            
                        </div>
                        <div v-if="movement === 'Entrada' && (transaction.warehouse === 'Bodega' || transaction.warehouse === 'Proceso')" class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="supplier">Proveedor:</label>
                                <input class="form-control" id="supplier" type="text" v-model="transaction.supplier" placeholder="" v-validate="'required'" data-vv-scope="transaction" data-vv-as="Proveedor"
                                    name="supplier" :class="{ 'is-invalid': submitted &amp;&amp; errors.has('transaction.supplier') }" />
                                <div class="invalid-feedback" v-if="submitted &amp;&amp; errors.has('transaction.supplier')">{{ errors.first('transaction.supplier') }}</div>
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div v-if="transaction.movement === 'Entrada' && (transaction.warehouse === 'Entrega' || transaction.warehouse === 'Proceso')" class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="wonumber">Orden de Trabajo:</label>
                                <input class="form-control" id="wonumber" type="text" v-model="transaction.wo" placeholder="" v-validate="'required'" data-vv-scope="transaction" data-vv-as="Orden de Trabajo"
                                    name="wonumber" :class="{ 'is-invalid': submitted &amp;&amp; errors.has('transaction.wonumber') }" />
                                <div class="invalid-feedback" v-if="submitted &amp;&amp; errors.has('transaction.wonumber')">{{ errors.first('transaction.wonumber') }}</div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" @click="saveMov('transaction')">Guardar Transacción</button>
                </div>
            </div>
        </div>
    </div>
</div>
    
</template>
<script>
export default {
    mounted() {
        console.log('Component mounted.');
    },
    data(){
        return {
            transactions: [],
            transaction: {
                movement: 'Entrada',
                warehouse: 'Bodega',
            },
            movement: 'Entrada',
            current_date : null,
            warehouses: [
                'Bodega',
                'Proceso',
                'Entrega',
            ],
            warehouse: 'Bodega',
            movements: [
                'Entrada',
                'Salida',
                'Interno',
            ],
            locations: [],
            options: [],
            submitted: false,
            
        }
    },
    methods:{
        changeLocations(){
            console.log(this.transaction.warehouse)
            this.options = this.locations.filter(l => l.warehouse == this.transaction.warehouse);
        },
        getTransactions(){
            this.showLoading();
            axios.get('/api/transaction')
                .then(response => {
                    this.transactions = response.data;
            })
            this.stopLoading();
        },
        getLocations(){
            this.showLoading();
            axios.get('/api/locations')
                .then(response => {
                    this.locations = response.data;
                    if(this.locations.length > 0){
                        this.changeLocations();
                    }
                    // this.locations.errors = [];
            })
            this.stopLoading();
        },
        mytable(){
            $(function() {
                $('#transactions').DataTable({
                    "order": [[6, "asc"]],
                    searching: true,
                    bLengthChange: false,
                    bFilter: true,
                    bInfo: false,
                    bAutoWidth: false,
                    "language": {
                        "emptyTable": "No se encontraron registros",
                        "zeroRecords": "No se encontraron registros",
                        "search": "Filtar:"
                    },     
                    "drawCallback": function( settings ) {
                        $('.pagination .previous .page-link').html('<i class="fas fa-angle-left"></i>');
                        $('.pagination .next .page-link').html('<i class="fas fa-angle-right"></i>'); 
                    }   
                });
            });   
        },
        saveMov(scope) {
            this.submitted = true;
            if(isNaN(parseFloat(this.transaction.quantity)) && !isFinite(this.transaction.quantity)){
                    this.ShowMessagePopup('Ingrese una cantidad valida', 1)
                    return;
                }
            this.$validator.validateAll(scope).then(valid => { 
                if (valid) {                        
                    this.showLoading();
                    this.transaction.errors = [];
                    this.message = "";
                    axios.post('/api/transaction', this.transaction)
                    .then(response => {
                        this.location = {
                            errors: []
                        }
                        // $('#transactionModal').modal('hide')
                        this.submitted = false;
                        this.transactions = response.data;
                        this.stopLoading();
                    }).catch(errors => {
                        this.submitted = false;
                        this.stopLoading();
                        if(typeof errors.response.data === 'object'){
                            if(errors.response.data.errors != undefined)
                                this.transaction.errors = _.flatten(_.toArray(errors.response.data.errors))
                            if(errors.response.data.error != undefined)
                                this.transaction.errors = [errors.response.data.error];
                            else
                                this.transaction.errors = ['Algo salio mal!']
                        }                                   
                        else
                            this.transaction.errors = ['Algo salio mal!']
                    })
                    this.$forceUpdate();
                    this.stopLoading();
                    $('#transactionModal').modal('hide');
                }
            });
        },
        newMov(){
            this.transaction.location = '';
            this.transaction.id = 0;
            $('#transactionModal').modal('show');
        },
    },
    created: function(){
        this.getLocations();
        this.getTransactions();
    }
}
</script>

<style>
    .ocultar {
        display: none;
    }
</style>