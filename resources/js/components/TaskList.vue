<template>
    <div>
        <h1>Add Task</h1>
        <div class="row">
            <form @submit.prevent="addTask()" class="form-inline small">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="name" class="sr-only">Name</label>
                    <input type="input" class="form-control" id="name" placeholder="Name" v-model="name">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="priority" class="sr-only">Priority</label>
                    <select name="" id="" class="form-control">
                        <option selected disabled>Priority</option>
                        <option>Normal</option>
                        <option>High</option>
                        <option>Urgent</option>
                    </select>
                </div>
`               <div class="form-group mx-sm-3">
                    <button type="submit" class="btn btn-success mb-2">Save task</button>
                </div>`
            </form>
        </div>
        <h1 class="mt-5">Tasks</h1>
        <div class="row">
            <div class="col-md-5">
                <label for="projects">Sort tasks by project</label>
                <select name="" id="" class="form-control mb-3">
                    <option value="" selected disabled>Select Project</option>
                </select>
                <table class="table border">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <tr  v-for="task in tasks" v-bind:key="task.id">
                            <td>
                                {{task.id}}
                            </td>
                            <td>
                                {{task.name}}
                            </td>
                            <td>
                                <span v-if="task.priority == 0">Normal</span>
                                <span v-if="task.priority == 1">High</span>
                                <span v-if="task.priority == 2">Urgent</span>
                            </td>
                            <td>
                                <select v-if="task.completed == false" name="" id="" class="btn btn-mini btn-success">
                                    <option selected disabled>Not done</option>
                                    <option>Done</option>
                                </select>
                                <button class="btn btn-sm btn-light" v-if="task.completed == true" disabled>Done</button>
                            </td>
                            <td>
                                <button class="btn btn-secondary"><i class="fa fa-trash fa-sm"></i> Delete</button>
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
        data() {
            return {
                tasks:[],
                name: '',
                priority: 0
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            getTasks() {
                axios.get('/api/task').then(res => {
                    if (res.status == 200) {
                        this.tasks = res.data;
                    }
                }).catch(err => {
                    console.log(err)
                });

            },
            addTask(){
                axios.post('/api/task', {
                    name: this.name,
                    priority: this.priority
                })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    currentObj.output = error;
                });  
            }
        },
        created() {
            this.getTasks();
        }
    }

</script>
