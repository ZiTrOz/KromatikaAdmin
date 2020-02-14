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
                            <button class="btn btn-sm btn-default" @click="newPo()">Nueva</button>
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
                    <h3 class="mb-0">Informacion de la Orden de Compra</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <!-- <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="po.errors.length > 0">
                        <span class="alert-inner--text">{{ po.errors }}</span>
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> -->
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="pos">
                            <thead class="thead-light">
                                <tr>
                                    <th>PO</th>
                                    <th>Folio</th>
                                    <th>Cliente</th>
                                    <th>Entrega</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(po, i) in pos" :key="i">
                                    <td>{{ po.ponumber }}</td>
                                    <td>{{ po.folio }}</td>
                                    <td>{{ po.customer }}</td>
                                    <td>{{ po.delivery }}</td>
                                    <td>{{ po.date }}</td>
                                    <td>{{ (po.total).toFixed(2) }}</td>
                                    <td><i class="fas fa-edit" @click="editPo(po)"></i></td>
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
//import DatatableFactory from 'vuejs-datatable';
    export default {
        //components: { DatatableFactory  },
        mounted() {
            console.log('Component mounted.');
        },
        data(){
            return {
                pos: [],
            }
        },
        methods:{
            editPo(po){
                window.location.href = "/oc/editar/" + po.id;
            },
            mytable(){
                $(function() {
                    $('#pos').DataTable({
                        searching: false,
                        bLengthChange: false,
                        bFilter: true,
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
            getPos() {
                axios.get('/api/po').then(response=>{
                    this.pos = response.data;
                    this.mytable();
                });
            },
            newPo(){
                window.location.href = "/oc/crear";
            }
        },
        created: function(){
            this.getPos()
        }
    }
</script>