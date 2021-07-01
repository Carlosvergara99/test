<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Crer Cuenta</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" v-model="formData.name" placeholder="name">
                            <p class="text-danger" v-text="errors.name"></p>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" v-model="formData.email" placeholder="email">
                            <p class="text-danger" v-text="errors.email"></p>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" v-model="formData.password"  placeholder="password">
                            <p class="text-danger" v-text="errors.password"></p>
                        </div>
                        <div class="form-group">
                            <label  for="password_confirmation">Rol</label>
                            <select  class="form-control" name="" id="" v-model="formData.role" >
                            <option value="">Seleccione</option>
                            <option value="2">Administrador</option>
                            <option value="1">Vendedor</option>
                            </select>


                            <p class="text-danger" v-text="errors.rol"></p>
                        </div>

                        <div class="row">
                           
                            <div class="col-md-6 ">
                                <router-link to="/login">Inicar Sesion</router-link>
                            </div>
                             <div class="col-md-6" >
                                <div class="form-group">
                                    <button @click.prevent="registerUser" style="float: right" class="btn btn-primary">Crear usuario</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                formData: {
                    name: '',
                    email: '',
                    password: '',
                    roleid: ''
                },
                errors: {}
            }
        },
        methods: {
            registerUser(){
                axios.post('api/auth/register', this.formData).then((response) => {
                    this.formData.name = this.formData.email = this.formData.password = this.formData.password_confirmation = ''
                    this.errors = {}
                    toast.fire({
                     icon: 'success',title: 'usuario registrado con exito'
                     })
                    this.$router.push('/login')
                }).catch((errors) => {
                    this.errors = errors.response.data.errors
                    toast.fire({
                     icon: 'error',title: 'error al registrar el usuario'
                     })
                });
            }
        }   
    }
</script>