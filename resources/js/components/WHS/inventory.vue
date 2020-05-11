<template>
<div>
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Inventario</h6>
                    </div>
                    <!-- <div class="col-lg-6 col-5 text-right">
                        <button class="btn btn-sm btn-default" @click="newMov()">Nuevo Movimiento</button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="card mb-4">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">Inventario</h3>
            </div>
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="date">Almacén:</label>
                            <multiselect v-model="warehouse" :options="warehouses" @close="filterTransactions()" :searchable="true" :close-on-select="true" :show-labels="false"></multiselect>
                        </div>
                    </div>
                </div>
                <div class="table-responsive py-4">                        
                    <table class="table table-flush" id="inventory">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>Almacen</th>
                                <th>Movimiento</th>
                                <th>Codigo</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Ubicación</th>
                                <!-- <th>Acciones</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(inv, i) in inventory" :key="i" class="text-center">
                                
                                <td>{{ inv.location.warehouse }}</td>
                                <td>{{ inv.location.location }}</td>
                                <td>{{ inv.code }}</td>
                                <td>{{ inv.item }}</td>
                                <td>{{ inv.quantity }}</td>
                                
                                <td>{{ inv.user.name }}</td>
                                <!-- <td> -->
                                    <!-- <i class="fas fa-eye" title="Ver Detalle" @click="viewDetail(wo)"></i>
                                    <i class="fas fa-edit" title="Editar" @click="editWo(wo)"></i>
                                    <i :class="{'fas fa-shipping-fast' : wo.status === 'Por Entregar'}" title="Entregar" @click="deliveryWo(wo)"></i>
                                    <i :class="{'fas fa-check' : wo.status === 'Entregado'}" title="Entregado"></i> -->
                                <!-- </td> -->
                            </tr>
                        </tbody>
                    </table>
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
            inventory: [],            
            warehouses: [
                'Bodega',
                'Proceso',
                'Entrega',
            ],
            warehouse: 'Bodega',            
            submitted: false,
            
        }
    },
    methods:{
        getInventory(){
            this.showLoading();
            axios.get('/api/inventory')
                .then(response => {
                    this.inventory = response.data;
                    
            })
            this.stopLoading();
        },
        mytable(){
            $(function() {
                $('#inventory').DataTable({
                    "order": [[3, "asc"]],
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
    },
    created: function(){
        this.getInventory();
    }
}
</script>
