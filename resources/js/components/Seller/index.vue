<template>
<div>
     <button class="btn btn-success" data-toggle="modal" data-target="#addCliente" @click="openModalWindow">Crear Cliente <i></i></button>
               <!-- <input type="text" v-model="buscar" class="form-control" placeholder=""/>               -->

    <br>
   <table class="table table-hover  table-bordered">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Documento</th>
        <th>Email</th>
        <th>Direccion</th>
        <th>Accion</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="client in clients" :key="client.id">
        <td>{{client.id}}</td>
        <td>{{client.name}}</td>
        <td>{{client.document}}</td>
        <td>{{client.email}}</td>
        <td>{{client.addres}}</td>
        <td><a href="#" data-id="user.id" class="btn btn-info" @click="editModalWindow(client)"> Editar</a>
            <a href="#" class="btn btn-danger" @click="DeleteClient(client.id)">Eliminar</a>
        </td>

      </tr>
    </tbody>
  </table>
     <div class="modal fade" id="addCliente" tabindex="-1" role="dialog" aria-labelledby="addClienteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">

                    <h5 v-show="!editMode" class="modal-title" id="addCliente">Crear Cliente </h5>
                    <h5 v-show="editMode" class="modal-title" id="addCliente">Actualizar Cliente</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form @submit.prevent="editMode ? updateClient() : createCliente()">
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
                      <label for="password">Documento</label>

                     <input v-model="form.document" type="number"  placeholder="Documento" class="form-control"  >
                      <p class="text-danger" v-text="errors.document"></p>

                   </div>

                   <div class="form-group">
                      <label  for="rol">Direccion</label>

                         <input v-model="form.addres" type="text"  placeholder="Direccion" class="form-control"  >

                        <p class="text-danger" v-text="errors.addres"></p>
                   </div>
              </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               <button v-show="editMode" type="submit" class="btn btn-primary">Actualizar </button>
               <button v-show="!editMode" type="submit" class="btn btn-primary">Crear</button>
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
                clients: {},
                form: {
                    name : '',
                    email: '',
                    document: '',
                    addres: '',
                },
                formedit:{},
                 errors: {},

            }
        },
    mounted() {
        this.geClient();
    },
    methods: {
    createCliente(){
         axios.post('api/client/store',this.form).then((response) => {
            this.clients =response.data
             $('#addCliente').modal('hide');
             toast.fire({
                icon: 'success',title: 'Cliente registrado con exito'
              })
             this.geClient();
         }).catch((errors) => {
           this.errors = errors.response.data.errors

         })
    },
    updateClient(){
      const data  ={
        'id' :this.formedit.id,
        'name' : this.form.name,
        'email':this.form.email,
        'document': this.form.document,
        'addres':this.form.addres
      }
       axios.post('api/client/update',data).then((response) => {
            const index = this.clients.findIndex(item => item.id === response.data.id);
             this.clients[index] = response.data;
            $('#addCliente').modal('hide');
             toast.fire({
                icon: 'success',title: 'Clienete  actualizado con exito'
              })
              this.geClient()
         }).catch((errors) => {
          this.errors = errors.response.data.errors
               toast.fire({
                icon: 'error',title: 'Error al  actualizadar el usuario'
              })
         })
    },
    DeleteClient(data){
      Swal.fire({
        title: 'Esta seguro de eliminar el cliente!',
       showCancelButton: true,
       confirmButtonText: `Eliminar `,
       }).then((result) => {
       if (result.isConfirmed) {
         let dato ={
           'id':data
         }
          axios.post('api/client/delete',dato).then((response) => {
            const index = this.clients.findIndex(item => item.id === data);
            this.clients.splice(index, 1);
            toast.fire({
                icon: 'success',title: 'cliente eliminado'
              })
              this.geClient()
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
        $('#addCliente').modal('show');
     },
     editModalWindow(user){
       this.errors ={}
        this.editMode = true;
         this.form ={ 
             'name' : user.name,
             'email':  user.email,
             'document': user.document,
             'addres':user.addres
            }
          this.formedit ={ 
             'id' : user.id
           }
        $('#addCliente').modal('show');
        },
    geClient(){
          axios.get('api/client/get').then((response) => {
            this.clients =response.data
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