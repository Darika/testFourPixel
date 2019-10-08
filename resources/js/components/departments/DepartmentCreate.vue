<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">Create new department</div>
            <div class="panel-body">
                <template v-if="errors">
                <div class="alert alert-danger" id="errors">
                    <ul>
                        <li v-for="(item, index) in errors">{{ item[0] }}</li>
                    </ul>
                </div>
                </template>
                <form v-on:submit="saveForm()" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label class="control-label">Department name</label>
                            <input type="text" v-model="department.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label class="control-label">Department description</label>
                            <textarea v-model="department.description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label class="control-label">Department logo</label>
                            <input type="file" @change="processFile($event)" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <label class="control-label">Users</label>
                            <ul>
                                <li v-for="user, index in users">
                                    <input type="checkbox" v-model="department.users" v-bind:value="user.id">
                                    <label for="checkbox">{{ user.name }}</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Create</button>
                            <router-link to="/" class="btn btn-default">Back</router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            var app = this;
            axios.get('/api/v1/users')
                .then(function (resp) {
                    app.users = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Failed to load users");
                });
        },
        data: function () {
            return {
                department: {
                    name: '',
                    description: '',
                    logo: null,
                    users: [],
                },
                users:[],
                errors:null
            }
        },
        methods: {
            processFile(event) {
                this.department.logo = event.target.files[0]
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                var newDepartment = new FormData();
                var user_arr = JSON.stringify(app.department.users);
                newDepartment.append('name', app.department.name);
                newDepartment.append('description', app.department.description);
                newDepartment.append('logo', app.department.logo);
                newDepartment.append('users', user_arr);
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                };
                axios.post('/api/v1/departments',  newDepartment, config)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        var errors = JSON.parse(resp.request.response);
                        app.errors = errors.errors;
                        VueScrollTo.scrollTo($('#errors', 500));
                    });
            }
        }
    }
</script>