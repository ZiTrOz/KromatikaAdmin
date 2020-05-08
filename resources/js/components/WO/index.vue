<template>
    <div>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Ordenes de Compra</h6>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <button class="btn btn-sm btn-default" @click="newWo()">Nueva Orden de Trabajo</button>
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
                                <label class="form-control-label" for="date">Mostrar:</label>
                                <multiselect v-model="woFilter" @input="getWos()" :options="filters" :searchable="true" :close-on-select="true" :show-labels="false"></multiselect>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive py-4">                        
                        <table class="table table-flush" id="wos">
                            <thead class="thead-light">
                                <tr>
                                    <th>Orden de Trabajo</th>
                                    <th>Folio</th>
                                    <th>Cliente</th>
                                    <th>Entrega</th>
                                    <th>Equipo</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Total</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(wo, i) in wos" :key="i" :class="{ 'prioridadalta': compareDates(wo) <= 2, 
                                    'prioridadmedia': compareDates(wo) > 2 && compareDates(wo) <= 4 }" >
                                    
                                    <td>{{ wo.wonumber }}</td>
                                    <td>{{ wo.folio }}</td>
                                    <td>{{ wo.customer }}</td>
                                    <td>{{ wo.delivery }}</td>
                                    <td>{{ wo.machine }}</td>
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
    </div>
</template>
<script>  
    export default {
        mounted() {
            console.log('Component mounted.');
        },
        data(){
            return {
                wos: [],
                current_date : null,
                filters: [
                    'En proceso',
                    'Terminadas',
                ],
                woFilter: 'En proceso'
            }
        },
        methods:{
            deliveryWo(wo){
                window.location.href = "/ordentrabajo/entrega/" + wo.id;
            },
            editWo(wo){
                window.location.href = "/ordentrabajo/editar/" + wo.id;
            },
            viewDetail(wo){
                window.location.href = "/ordentrabajo/detalle/" + wo.id;
            },
            mytable(){
                $(function() {
                    $('#wos').DataTable({
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
            getWos() {
                axios.get('/api/wo/filter/' + this.woFilter).then(response=>{
                    //$('#wos').DataTable().destroy();
                    this.wos = response.data;
                    this.mytable();
                });
            },
            newWo(){
                window.location.href = "/ordentrabajo/crear";
            },
            compareDates(wo){
                let delivery_date = moment(wo.delivery_date);
                let current_date = moment();
                let diff = delivery_date.diff(current_date, 'd');
                console.log(diff, wo.delivery_date);
                return diff;
            }
        },
        created: function(){
            this.getWos();
            //this.current_date = moment();
        }
    }
</script>

<style>
    .prioridadalta {
        background-color: #f5365c!important;
    }
    .prioridadmedia {
        background-color: yellow!important;
    }
</style>