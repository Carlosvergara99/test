<template>
    <div>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Inciar Sesion</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" v-model="data.email" placeholder="Email">
                            <!-- <p class="text-danger" v-text="errors.email"></p> -->
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" v-model="data.password" placeholder="Contraseña">
                            <!-- <p class="text-danger" v-text="errors.password"></p> -->
                        </div>

                        <div class="row">
                            
                            <div class="col-md-6 ">
                                <router-link to="/register">Crear Cuenta </router-link>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group">
                                    <button @click.prevent="login"  style="float: right" class="btn btn-primary">Login</button>
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
        data(){
            return {
                data: {
                    email: '',
                    password: ''
                },
                errors: {}
            }
        },
        methods: {
            login(){
                axios.post('http://localhost:8000/api/auth/login', this.data).then((response) => {
                     localStorage.setItem('token', response.data.access_token)
                    this.$router.push('/')
                }).catch((errors) => {
                    this.errors = errors.response.data.errors
                })
            }
        }
    }
</script>