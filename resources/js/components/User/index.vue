<template>
<div>
     <button class="btn btn-success" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Crear Usario <i></i></button>
    <br>
   <table class="table table-hover  table-bordered">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="user in users" :key="user.id">
        <td>{{user.id}}</td>
        <td>{{user.name}}</td>
        <td>{{user.email}}</td>
        <td>{{user.rol}}</td>
        <td><a href="#" data-id="user.id" class="btn btn-info" @click="editModalWindow(user)"> Editar</a>
            <a href="#" class="btn btn-danger">Eliminar</a>
        </td>

      </tr>
    </tbody>
  </table>
     <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">

                    <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Crear Usuario</h5>
                    <h5 v-show="editMode" class="modal-title" id="addNewLabel">Actualizar Usuario</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form @submit.prevent="editMode ? updateUser() : createUser()">
                     <div class="modal-body">
                      <div class="form-group">
                        <input v-model="form.name" type="text" name="name" placeholder="Name" class="form-control" >
                    </div>

                    <div class="form-group">
                     <input v-model="form.email" type="email" name="email" placeholder="Email " class="form-control" >
                   </div>

                   <div class="form-group">
                     <input v-model="form.password" type="password" name="password" id="password" placeholder="password" class="form-control"  >
                   </div>

                   <div class="form-group">
                      <select name="type" v-model="form.type" id="type" class="form-control" p >
                         <option value="">Select Rol</option>
                         <option value="2">Admin</option>
                         <option value="1">Vendedor</option>

                      </select>
                   </div>
              </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
               <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
           </div>
        </form>
       </div>
    </div>
</div>
</div> 

</template>

<script>
export default {
    data() {
            return {
                editMode: false,
                users: {},
                form: {
                    id: '',
                    name : '',
                    email: '',
                    password: '',
                    type: ''
                },
            }
        },
    mounted() {
        this.getUser();
    },
    methods: {
    createUser(){
    },
    updateUser(){
    },
    openModalWindow(){
         this.editMode = false
        $('#addNew').modal('show');
     },
     editModalWindow(user){
        this.editMode = true
        $('#addNew').modal('show');
        },
    getUser(){
          axios.get('api/users/get').then((response) => {
            this.users =response.data
         }).catch((errors) => {
            console.log(errors)
         })
      }
    }
    
}
</script>

<style>

</style>