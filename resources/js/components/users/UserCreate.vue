<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">Create new user</div>
            <div class="panel-body">
                <template v-if="errors">
                    <div class="alert alert-danger" id="errors">
                        <ul>
                            <li v-for="(item, index) in errors">{{ item[0] }}</li>
                        </ul>
                    </div>
                </template>
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">User name</label>
                            <input type="text" v-model="user.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">User email</label>
                            <input type="text" v-model="user.email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Password</label>
                            <input type="password" v-model="user.password" class="form-control">
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
        data: function () {
            return {
                user: {
                    name: '',
                    email: '',
                    password:'',
                },
                errors:null
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newUser = app.user;
                axios.post('/api/v1/users', newUser)
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