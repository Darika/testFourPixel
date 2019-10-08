<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createDepartment'}" class="btn btn-success">Create new department</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Departments list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Users</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="department, index in departments">
                        <td>{{ department.logo }}</td>
                        <td>{{ department.name }}</td>
                        <td><label v-for="(item, index) in department.user">{{ item.name }}</label></td>
                        <td>
                            <router-link :to="{name: 'editDepartment', params: {id: department.id}}" class="btn btn-xs btn-default">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(department.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                departments: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/departments')
                .then(function (resp) {
                    app.departments = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Failed to load departments");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete the department?")) {
                    var app = this;
                    axios.delete('/api/v1/departments/' + id)
                        .then(function (resp) {
                            app.departments.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete department");
                        });
                }
            }
        }
    }
</script>