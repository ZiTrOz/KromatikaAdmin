<template>
<div>
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Ubicaciones</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right"><button class="btn btn-sm btn-default" @click="newLocation()">Nueva Ubicación</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="mb0">Ubicaciones Registradas</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-danger fade show" role="alert" v-if="location.errors.length > 0">
                    <a href="#" class="close" aria-label="close" @click="hideAlert()">&times;</a>
                    <div v-for="(error,i) in location.errors" :key="i">
                        <label>{{ error }}</label><br/>
                    </div>    
                </div>
                <!-- <div class="alert alert-danger fade show" role="alert" v-if="location.error.length > 0">
                    <a href="#" class="close" aria-label="close" @click="hideAlert()">&times;</a>
                    <label>{{ location.error }}</label><br/>
                </div> -->
                <div class="col-md-4">
                    <label class="form-control-label" for="location">Almacén</label>
                    <multiselect v-model="location.warehouse" :options="warehouses" @close="getLocationsByWarehouse()" :searchable="true" :close-on-select="true" placeholder="" :show-labels="false"></multiselect>
                </div>
                <div class="table-responsive py-4">
                    <table class="table align-items-center table-flush table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Almacén</th>
                                <th>Ubicación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(l, i) in locations" :key="i">
                                <td>{{ l.warehouse }}</td>
                                <td>{{ l.location }}</td>
                                <td><i class="fas fa-edit" title="Editar" @click="editLocation(l)"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-botton: 0px;">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Ubicación</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                <div class="modal-body" style="padding-top: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label" for="location">Almacén</label>
                                <multiselect v-model="location.warehouse" :options="warehouses" :searchable="true" :close-on-select="true" :show-labels="false" placeholder=""
                                    v-validate="'required'" data-vv-as="Almacén" name="warehouse" 
                                        :class="{ 'is-invalid': submitted && errors.has('warehouse') }"></multiselect>
                                <div v-if="submitted && errors.has('warehouse')" class="invalid-feedback">
                                    {{ errors.first("warehouse") }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label" for="location">Ubicación:</label>
                                <input class="form-control" id="location" type="text" v-model="location.location" placeholder="" v-validate="'required'" data-vv-scope="location" data-vv-as="Ubicación"
                                    name="location" :class="{ 'is-invalid': submitted &amp;&amp; errors.has('location.location') }" />
                                <div class="invalid-feedback" v-if="submitted &amp;&amp; errors.has('location.location')">{{ errors.first('location.location') }}</div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button><button class="btn btn-primary" type="button" @click="saveLocation('location')">Guardar Ubicación</button></div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: {
            title: '',
            id: '',
        },
    	data(){
    		return {
				location: {					
                    warehouse: '',
                    location: '',
                    id: 0,                  
                    errors: [],
                    error: []
				},    			
                submitted: false,
                message: "",
                locations: {
                    errors: []
                },
                warehouses: [
                    'Bodega',
                    'Proceso',
                    'Entrega',
                ]
    		}
    	},
    	methods: { 
            newLocation() {
                this.location.location = '';
                this.location.id = 0;
                $('#locationModal').modal('show');
            },
            editLocation(location) {
                // this.location = location;
                this.location.id = location.id;
                this.location.warehouse = location.warehouse;
                this.location.location = location.location;
                $('#locationModal').modal('show');
            },
            getLocations(){
                this.showLoading();
                axios.get('/api/locations')
                    .then(response => {
                        this.locations = response.data;
                        // this.locations.errors = [];
                })
                this.stopLoading();
            },
            getLocation(id){
                this.showLoading();
                axios.get('/api/locations/' + id)
                    .then(response => {
                        this.location = response.data;
                        // this.location.errors = [];
                })
                this.stopLoading();
            },
             getLocationsByWarehouse(){
                this.showLoading();
                axios.get('/api/locations/getByWarehouse/' + this.location.warehouse)
                    .then(response => {
                        this.locations = response.data;
                        // this.locations.errors = [];
                })
                this.stopLoading();
            },
    		saveLocation(scope){
                this.submitted = true;
                this.$validator.validateAll(scope).then(valid => {
    				if (valid) {                        
                        this.showLoading();
    					this.location.errors = [];
                        this.message = "";
                        if(this.location.id === 0){
                            axios.post('/api/locations', this.location)
                            .then(response => {
                                this.location = {
                                    errors: []
                                }
                                $('#locationModal').modal('hide')
                                this.submitted = false;
                                // this.locations = response.data;
                                // this.location.errors = []
                                // this.location.error = [];
                                // this.location.id = 0;
                                // this.location.warehouse = '';
                                // this.location.location = '';
                                this.stopLoading();
                            }).catch(errors => {
                                this.submitted = false;
                                this.stopLoading();
                                if(typeof errors.response.data === 'object'){
                                    if(errors.response.data.errors != undefined)
                                        this.location.errors = _.flatten(_.toArray(errors.response.data.errors))
                                    if(errors.response.data.error != undefined)
                                        this.location.errors = [errors.response.data.error];
                                    else
                                        this.location.errors = ['Algo salio mal!']
                                }                                   
                                else
                                    this.location.errors = ['Algo salio mal!']
                            })
                            this.$forceUpdate();
                            this.stopLoading();
                            $('#locationModal').modal('hide');
                        }
                        else{
                            axios.put('/api/locations/' + this.location.id, this.location)
                            .then(response => {
                                this.location = {
                                    errors: []
                                }
                                $('#locationModal').modal('hide')
                                this.submitted = false;
                                this.locations = response.data;
                                // this.location.errors = []
                                // this.location.error = [];
                                // this.location.id = 0;
                                // this.location.warehouse = '';
                                // this.location.location = '';
                                this.stopLoading();
                            }).catch(errors => {
                                this.submitted = false;
                                this.stopLoading();
                                if(typeof errors.response.data === 'object'){
                                    if(errors.response.data.errors != undefined)
                                        this.location.errors = _.flatten(_.toArray(errors.response.data.errors))
                                    if(errors.response.data.error != undefined)
                                        this.location.errors = [errors.response.data.error];
                                    else
                                        this.location.errors = ['Algo salio mal!']
                                }                                   
                                else
                                    this.location.errors = ['Algo salio mal!']
                            })
                                this.$forceUpdate();
                                this.stopLoading();
                                $('#locationModal').modal('hide');
                        }
						
                    }
    			});
			},
    	},
    	mounted(){
            if(this.id > 0){
                this.getLocation(this.id);
            }
            this.getLocations();
		},
}
</script>