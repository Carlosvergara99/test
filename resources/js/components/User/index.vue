<template>
<div>
     <button class="btn btn-success" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Crear Usario <i></i></button>
               <!-- <input type="text" v-model="buscar" class="form-control" placeholder=""/>               -->

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
        <td>{{user.roles[0].name}}</td>
        <td><a href="#" data-id="user.id" class="btn btn-info" @click="editModalWindow(user)"> Editar</a>
            <a href="#" class="btn btn-danger" @click="DeleteUser(user.id)">Eliminar</a>
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
                       <label for="name">Nombre</label>
 
                        <input v-model="form.name" type="text" name="name" placeholder="Name" class="form-control" >
                        <p class="text-danger" v-text="errors.name"></p>

                    </div>

                    <div class="form-group">
                     <label for="email">Email</label>
                     <input v-model="form.email" type="email" name="email" placeholder="Email " class="form-control" >
                       <p class="text-danger" v-text="errors.email"></p>
                   </div>

                   <div class="form-group">
                      <label for="password">Contraseña</label>

                     <input v-model="form.password" type="password" name="password" id="password" placeholder="password" class="form-control"  >
                      <p class="text-danger" v-text="errors.password"></p>

                   </div>

                   <div class="form-group">
                      <label  for="rol">Rol</label>

                      <select name="type" v-model="form.roleid" id="role" class="form-control" placeholder="Seleccione">
                       <option value="">Seleccione</option>
                      <option value="2">Administrador</option>
                      <option value="1">Vendedor</option>
                      </select>
                        <p class="text-danger" v-text="errors.roleid"></p>
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
                    roleid: '',
                },
                formedit:{},
                 errors: {},
                    buscar: ''

            }
        },
    mounted() {
       var admin=  localStorage.getItem('admin')
        if (admin) {
          this.getUser();
     }
    },
    methods: {
    createUser(){
         axios.post('api/auth/register',this.form).then((response) => {
            this.users =response.data
             $('#addNew').modal('hide');
             toast.fire({
                icon: 'success',title: 'usuario registrado con exito'
              })
             this.getUser();
         }).catch((errors) => {
           this.errors = errors.response.data.errors

         })
    },
    updateUser(){
      const data  ={
        'id' :this.formedit.id,
        'name' : this.form.name,
        'email':this.form.email,
        'roleid': this.form.roleid
      }
       axios.post('api/users/update',data).then((response) => {
            const index = this.users.findIndex(item => item.id === response.data.id);
             this.users[index] = response.data;
            $('#addNew').modal('hide');
             toast.fire({
                icon: 'success',title: 'usuario  actualizado con exito'
              })
              this.getUser()
         }).catch((errors) => {
          this.errors = errors.response.data.errors
               toast.fire({
                icon: 'error',title: 'Error al  actualizadar el usuario'
              })
         })
    },
    DeleteUser(data){
      Swal.fire({
        title: 'Esta seguro de eliminar el usuario!',
       showCancelButton: true,
       confirmButtonText: `Eliminar `,
       }).then((result) => {
       if (result.isConfirmed) {
         let dato ={
           'id':data
         }
          axios.post('api/users/delete',dato).then((response) => {
            const index = this.users.findIndex(item => item.id === data);
            this.users.splice(index, 1);
            toast.fire({
                icon: 'success',title: 'usuario eliminado con exito'
              })
              this.getUser()
          })
     }
    })
        
      
    },
    openModalWindow(){
         this.errors ={}
         this.editMode = false
          this.form= {
                    id: '',
                    name : '',
                    email: '',
                    password: '',
                    roleid: ''
                },
        $('#addNew').modal('show');
     },
     editModalWindow(user){
       this.errors ={}
        this.editMode = true;
         this.form ={ 
             'name' : user.name,
             'email':  user.email,
             'roleid': user.roles[0].id
            }
          this.formedit ={ 
             'id' : user.id
           }
        $('#addNew').modal('show');
        },
    getUser(){
          axios.get('api/users/get').then((response) => {
            this.users =response.data
         }).catch((errors) => {
            console.log(errors)
         })
      }
    },
    computed: {
    searchUser() {
 return datos.filter(item => {
        return item.name.toLowerCase().includes(this.buscar.toLowerCase());
      });
       }
    }
    
    
}
</script>

<style>

</style>