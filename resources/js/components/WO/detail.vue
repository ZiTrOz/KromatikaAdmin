<template>
    <div>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Orden de Trabajo</h6>
                        </div>
                        <!-- <div class="col-lg-6 col-5 text-right">
                            <button class="btn btn-sm btn-default" @click="newPo()">Nueva</button>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="mb-0">Detalle de la Orden de Trabajo: {{wo.wonumber}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="pos">
                            <thead class="thead-light">
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Descrición</th>
                                    <th>Precio</th>
                                    <th>Equipo</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(d, i) in wo.wodetail" :key="i">
                                    <td>{{ d.quantity }}</td>
                                    <td>{{ d.description }}</td>
                                    <td>{{ '$ ' + addCommas(d.price) }}</td>
                                    <td>{{ d.machine }}</td>
                                    <td>{{ d.status }}</td>
                                    <td>
                                        <i class="fas fa-eye" title="Ver Producción" @click="viewProd(d)"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="padding-botton: 0px;">
                        <h5 v-if="detail.length > 0" class="modal-title" id="exampleModalLabel">{{ detail[0].wodetail.description }}</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    <div class="modal-body" style="padding-top: 0px;">
                        <h4 v-if="detail.length == 0">Sin registro de producción</h4>
                        <div class="table-responsive py-4">
                            <table v-if="detail.length > 0" class="table table-flush" id="pos">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Proceso</th>
                                        <th>Usuario</th>
                                        <th>Tiempo</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Notas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(d, i) in detail" :key="i">
                                        <td>{{ d.process }}</td>
                                        <td>{{ d.user.name }}</td>
                                        <td>{{ d.time }}</td>
                                        <td>{{ d.created_at | moment('DD/MM/YYYY') }}</td>
                                        <td>{{ d.created_at | moment('hh:mm:ss a') }}</td>
                                        <td>{{ d.notes }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>  
    export default {
        props: {
            title: '',
            id: ''
        },
        mounted() {
        },
        data(){
            return {
                wo: [],
                detail: {
                    user: {
                        name: ''
                    }
                },
            }
        },
        methods:{
            getWo(id){
                axios.get('/api/wo/' + id)
                    .then(response => {
                        this.wo = response.data;
                        this.wo.errors = [];
                    })
            },
            getDetail(id){
                axios.get('/api/production/getdetail/' + id)
                    .then(response => {
                        this.detail = response.data;
                    })
            },
            viewProd(detail){
                this.getDetail(detail.id);
                $('#detailModal').modal('show');
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
        created: function(){
            if(this.id > 0){
                this.getWo(this.id);
            }
            else{
                alert('No se envio ninguna orden de trabajo');
                window.location.href = "/ordentrabajo";
            } 
        }
    }
</script>