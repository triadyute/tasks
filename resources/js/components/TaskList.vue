<template>
    <div class="container">
        <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
        <h1>Add Task</h1>
            <form @submit.prevent="addTask()" class="small">
            <div class="row">
                <div class="col-md-3">
                <select id="" class="form-control mb-3" @change="alert('clicked!')">
                    <option value="" selected disabled>Select Project</option>
                    <option value="">Project 1</option>
                    <option value="">Project 2</option>
                </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">  
                                <label for="name" class="sr-only">Name</label>
                                <input type="input" class="form-control mb-3" id="name" placeholder="Name" v-model="task.name">
                </div>
                <div class="col-md-2">
                                <label for="priority" class="sr-only">Priority</label>
                                <select v-model="task.priority" class="form-control mb-3">
                                    <option selected disabled>Priority</option>
                                    <option value="0">Low</option>
                                    <option value="1">Med</option>
                                    <option value="2">High</option>
                                </select>
                </div>
                <div class="col-md-2">
                <button type="submit" class="btn btn-success">Save task</button>
                </div>
            </div>
            </form>

        <h1 class="mt-4">Tasks</h1>
        <div class="row">
            <div class="col-md-6">  
                    <flash-message class="myCustomClass"></flash-message>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7" v-if="Object.keys(tasks).length != 0">
                <label for="projects">Sort tasks by project</label>
                <select id="" class="form-control mb-3">
                    <option value="" selected disabled>Select Project</option>
                </select>
                <table class="table border">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Priority</th>
                        <th>Completed</th>
                        <th>Actions</th>
                    </thead>
                    <tbody transition="fade-transition">
                        <tr  v-for="task in tasks" :key="task.id">
                            <td>
                                {{task.id}}
                            </td>
                            <td>
                                {{task.name}}
                            </td>
                            <td>
                                <select name="" id="priority_dropdown" :class="priorityClasses(task)" @change="updateTask(task)">
                                    <option value="0" :selected="task.priority == 0">Low</option>
                                    <option value="1" :selected="task.priority == 1">Med</option>
                                    <option value="2" :selected="task.priority == 2">High</option>
                                </select>
                            </td>
                            <td>
                                <toggle-button
                                :value="Boolean(task.completed)"
                                :labels="{checked: 'Yes', unchecked: 'No'}"
                                @change="updateTask(task)">
                                </toggle-button>
                            </td>
                            <td>
                                <button class="btn btn-secondary" @click="deleteTask(task)"><i class="fa fa-trash fa-sm"></i> Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
             <div v-else class="col-md-6">
                 <p>No tasks to show</p>
             </div>
        </div>
    </div>
</template>

<script>
    // Import component
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    //Toggle button
    import { ToggleButton } from 'vue-js-toggle-button';
    //Vue toasted
    import Toasted from 'vue-toasted';
    Vue.use(Toasted);

    export default {
        data() {
            return {
                tasks:[],
                task:{
                    name: '',
                    priority: 0,
                    completed: false
                },
                //Vue loader options
                isLoading: false,
                fullPage: true,
            }
        },
        components: {
            Loading,
            ToggleButton
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
                    this.isLoading = true;
                    axios.post('/api/task', this.task)
                    .then(savedTask => {
                        this.tasks.push(savedTask);
                        this.task.name = '';
                        this.task.priority = 0;
                        this.getTasks();
                    })
                    .catch(err => {
                        console.log(err)
                    });
                    setTimeout(() => {
                    this.isLoading = false
                    },2000);

                    setTimeout(function(){               
                        let toast = Vue.toasted.success( "Task added successfully", { 
                            theme: "toasted-primary", 
                            position: "top-left", 
                            duration : 3000,
                            fitToScreen: true
                        });
                    }, 2000);
            },
            updateTask(task){
                    axios.put('/api/task/' + task.id, task)
                    .then(
                        this.task = task,
                        this.task.completed = !this.task.completed,
                        console.log(this.task),
                        this.getTasks(),
                        this.task.name = '',
                        this.task.priority = 0,
                    )
                    .catch(err => {
                        console.log(err)
                    });
            },
            deleteTask(task){
                this.isLoading = true;
                if (confirm('Are you sure'))
                {
                    axios.delete('/api/task/' + task.id )
                    .then(
                        this.getTasks()
                        )
                    .catch(err => {
                        console.log(err)
                        });
                }
                setTimeout(() => {
                this.isLoading = false
                },2000);

                setTimeout(function(){               
                    let toast = Vue.toasted.success( "Task deleted successfully", { 
                        theme: "toasted-primary", 
                        position: "top-left", 
                        duration : 3000,
                        fitToScreen: true
                    });
                }, 2000);
            },
                    //Priority css classes
            priorityClasses(task){
                if(task.priority == 0){
                    return "btn low"
                }
                else if(task.priority == 1){
                    return "btn med"
                }
                else{
                    return "btn high"
                }
            },
        },
        created() {
            this.getTasks();
        }
    }

</script>
