<template lang="pug">
    div
        .header.bg-primary.pb-6
            .container-fluid
                .header-body
                    .row.align-items-center.py-4
                        .col-lg-6.col-7
                            h6.h2.text-white.d-inline-block.mb-0 Usuarios
                        .col-lg-6.col-5.text-right
                            button.btn.btn-sm.btn-default(@click='newUser()') Nuevo Usuario
        // Page content
        .container-fluid.mt--6
            .card.mb-4
                // Card header
                .card-header
                    h3.mb-0 Usuarios Registrados
                // Card body
                .card-body                    
                    .table-responsive.py-4(v-cloak='')
                        table#users.table.table-flush.table-hover(class='table.align-items-center')
                            thead.thead-light
                                tr
                                    th Nombre
                                    th Correo
                                    th Acciones
                            tbody
                                tr(v-for='(user, i) in users', :key='i')
                                    td {{ user.name }}
                                    td {{ user.email }}
                                    td
                                        i.fas.fa-edit(title='Editar', @click='editUser(user)')
        #userModal.modal.fade(tabindex='-1', role='dialog', aria-labelledby='userModal', aria-hidden='true')
            .modal-dialog.modal-md(role='document')
                .modal-content
                    .modal-header(style="padding-botton: 0px;")
                        h5#exampleModalLabel.modal-title Nuevo Trabajo
                        button.close(type='button', data-dismiss='modal', aria-label='Close')
                            span(aria-hidden='true') &times;
                    .modal-body            
                        .alert.alert-danger.fade.show(role='alert', v-if='error.length > 0')
                            a.close(href='#', aria-label='close', @click='hideAlert()') &times;
                            div(v-for='(e,i) in error', :key='i')
                                label {{ e }}
                                br            
                        form.form-sample
                            .row
                                .col-md-12
                                    .form-group.row
                                        label.col-sm-4.col-form-label Nombre Completo
                                        .col-sm-8
                                            input.form-control(type='text' v-model="user.name" placeholder="" v-validate="'required'" data-vv-as="Nombre Completo" name="name" :class="{ 'is-invalid': submitted && errors.has('name') }")
                                            .invalid-feedback(v-if="submitted && errors.has('name')")
                                                | {{ errors.first("name") }}
                            .row
                                .col-md-12
                                    .form-group.row
                                        label.col-sm-4.col-form-label Correo Electrónico
                                        .col-sm-8
                                            textarea.form-control(type='text', v-model="user.email" v-validate="'required'" data-vv-as="Correo Electrónico" name="email" :class="{ 'is-invalid': submitted && errors.has('email') }")
                                            .invalid-feedback(v-if="submitted && errors.has('email')")
                                                | {{ errors.first("email") }}
                                        
                    .modal-footer
                        button.btn.btn-success(type='button', @click="store()") Guardar

</template>
<script>  
    export default {
        mounted() {
            console.log('Component mounted.');
        },
        data(){
            return {
                users: [],
                user: [],
                error: '',
                submitted: false
            }
        },
        methods:{
            editUser(user){
                this.user = user;
                $('#userModal').modal('show');
            },
            mytable(){
                $(function() {
                    $('#users').DataTable({
                        "order": [[0, "asc"]],
                        searching: true,
                        bLengthChange: false,
                        bFilter: true,
                        bInfo: false,
                        bAutoWidth: false,
                        "language": {
                            "emptyTable": "No se encontraron registros",
                            "zeroRecords": "No se encontraron registros",
                            "search": "Filtar: "
                        },     
                        "drawCallback": function( settings ) {
                            $('.pagination .previous .page-link').html('<i class="fas fa-angle-left"></i>');
                            $('.pagination .next .page-link').html('<i class="fas fa-angle-right"></i>'); 
                        }  
                    });
                });   
            },
            store() {
                this.submitted = true;
                this.$validator.validate().then(valid => { 
                    if(valid){
                        console.log(this.user);
                        this.showLoading();
                        this.error = [];
                        this.message = "";
                        if(this.user.id > 0)
                            this.edit(this.user);
                        else
                            this.save(this.user);
                    }
                });
            },
            save(user){
                let formData = new FormData();
                formData.append('user', JSON.stringify(user));
                axios.post('/api/users', formData).then(response => {
                    this.error = [];
                    this.submitted = false;
                    // $('#users').DataTable().destroy();                    
                    // this.users = response.data;
                    // this.mytable();
                    $('#userModal').modal('hide');
                    this.getUsers();
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
            },
            edit(user){
                axios.put('/api/users/' + this.user.id, user)
                .then(response => {
                    this.error = [];
                    this.submitted = false;
                    // $('#users').DataTable().destroy();  
                    // this.mytable();
                    // this.users = response.data;
                    this.getUsers();
                    
                    $('#userModal').modal('hide');
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
            },
            getUsers() {
                axios.get('/api/users').then(response=>{
                    $('#users').DataTable().destroy();
                    this.users = response.data;                    
                    this.mytable();
                });
            },
            newUser(user){
                this.user = {
                    name: '',
                    email: '',
                    id: 0
                };
                $('#userModal').modal('show');
            },
        },
        created: function(){
            this.getUsers();
            //this.current_date = moment();
        }
    }
</script>

<style>
    [v-cloak] {display: none}
</style>