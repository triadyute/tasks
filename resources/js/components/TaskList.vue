<template>
    <div>
        <h1>Add Task</h1>
        <div class="row">
            <form @submit.prevent="addTask()" class="form-inline small">
                <div class="form-group mx-sm-3">
                    <label for="name" class="sr-only">Name</label>
                    <input type="input" class="form-control" id="name" placeholder="Name" v-model="task.name">
                </div>
                <div class="form-group mx-sm-3">
                    <label for="priority" class="sr-only">Priority</label>
                    <select v-model="task.priority" class="form-control">
                        <option selected disabled>Priority</option>
                        <option value="0">Normal</option>
                        <option value="1">High</option>
                        <option value="2">Urgent</option>
                    </select>
                </div>
                <div class="form-group mx-sm-3">
                    <button type="submit" class="btn btn-success">Save task</button>
                </div>
            </form>
        </div>
        <h1 class="mt-5">Tasks</h1>
        <div class="row">
            <div class="col-md-6">
                <transition name="fade">
                    <flash-message class="myCustomClass"></flash-message>
                </transition>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="projects">Sort tasks by project</label>
                <select id="" class="form-control mb-3">
                    <option value="" selected disabled>Select Project</option>
                </select>
                <table class="table border">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </thead>
                    <tbody is="transition-group">

                        <tr  v-for="task in tasks" :key="task.id">
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
                                <button class="btn btn-secondary" @click="deleteTask(task)"><i class="fa fa-trash fa-sm"></i> Delete</button>
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
                task:{
                    name: '',
                    priority: 0
                }
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

                    axios.post('/api/task', this.task)
                .then(savedTask => {
                    this.tasks.push(savedTask);
                    this.getTasks();
                })
                .catch(err => {
                    console.log(err)
                });
            },
            deleteTask(task){
                if (confirm('Are you sure')) {
                axios.delete('/api/task/' + task.id )
                .then(
                    this.getTasks(),
                    this.flash('Task deleted', 'success',{
                        timeout:3000
                    })
                    )
                .catch(err => {
                    console.log(err)
                });

                //console.log(task);
                }
            }
        },
        created() {
            this.getTasks();
        }
    }

</script>
