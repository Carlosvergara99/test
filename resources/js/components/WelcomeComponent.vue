<template>
      <div class="container">
          <br>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h5 class="text-center">Bienvenido <strong> {{currentUser}} </strong>  <a class="btn btn-danger btn-xs" @click="logout">Logout</a></h5> 
            </div>
        </div>
        <br>

     <ul class="nav nav-pills nav-justified">
       <li class="active" ><a  v-if="admin" class="btn btn-primary" data-toggle="pill" href="#user">Usarios</a></li>&nbsp; 
       <li><a  class="btn" data-toggle="pill" href="#seller">Cliente</a></li>&nbsp; 
    </ul>
  
  <div class="tab-content">
    <div  id="user" class="tab-pane fade in active">
        <br>
     <User/>
    </div>
    <div id="seller" class="tab-pane fade">
        <br>
      <Seller/>
    </div>
    
  </div>
      </div>
</template>

<script>
import User from "./User/index.vue";
 import Seller from "./Seller/index.vue";

    export default {
        components: {
           User ,
           Seller
        },
        
           data() {
            return {
                employees: {},
                currentUser: {},
                token: localStorage.getItem('token'),
                admin:false,
                vendedor:true,
            }
        },
          mounted() {
             window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`

              let data = {'token':this.token}
               axios.post('api/auth/me',data).then((response) => {
                this.currentUser = response.data.name
                var UserId = response.data.id
                this.Permissson (UserId)
            }).catch((errors) => {
                console.log(errors)
            })
        },
        methods:{
            Permissson(data){
                let dato = {'id':data}

                axios.post('api/auth/permissson',dato).then((response) => {
                     if (response.data.role[0].role_id== 2) {
                        this.admin = true;
                        localStorage.setItem('admin',  this.admin)

                     }
                }).catch((errors) => {
                    console.log(errors)
                })  
            },
            logout(){
               let data = {'token':this.token}

                axios.post('api/auth/logout',data).then((response) => {
                    localStorage.removeItem('token')
                    localStorage.removeItem('admin')
                    this.$router.push('/login')
                }).catch((errors) => {
                    console.log(errors)
                })
            }
        }
    }
</script>