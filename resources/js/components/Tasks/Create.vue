<template>
    <div class="row">
        <div class="col-12">
            <table class="table ">
                <thead>
                </thead>
                <tbody  :class="editTaskId ? 'table-primary' : 'table-warning' ">
                <tr  :class="editTaskId ? 'd-none' : '' ">
                    <td>
                        <div class="input-group">
                            <span class="input-group-text">Добавить задачу:</span>
                            <input type="text" class="form-control" v-model="title"
                                   placeholder="введите задачу">
                            <button type="submit" :disabled="isDisabled" class="btn btn-success"
                                    @click.prevent="store()"><i class="bi bi-send"></i> Добавить
                            </button>
                        </div>

                    </td>
                </tr>
                <tr :class="editTaskId ? '' : 'd-none' ">
                    <td><span class="input-group-text">ID: {{ this.editTaskId }}</span></td>
                    <td><input type="text" class="form-control" v-model="title"
                               placeholder="введите задачу" value=""></td>
                    <td>
                        <select  class="form-select" name="status" v-model="status">
                            <option v-for="s_title in status_title" :value="getKeyByValue(status_title, s_title)">{{ s_title }}</option>
                        </select>
                    </td>
                    <td><a class="btn btn-outline-success" href="" @click.prevent="update()">ОБНОВИТЬ</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Задача</th>
            <th scope="col" @click.prevent="updateSort(this.sortType)">Статус <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5"/>
            </svg></th>
            <th scope="col">Создано</th>
            <th scope="col">Изменить</th>
            <th scope="col">Удалить</th>
        </tr>
        </thead>
        <tbody>
        <template v-for="task in sortTasks">
            <tr :class="isEdit(task.id) ? 'd-none' : '' ">
                <th scope="row">{{ task.id }}</th>
                <td>{{ task.title }}</td>
                <td>{{ this.status_title[task.status] }}</td>
                <td>{{ task.created_at }}</td>
                <td><a class="btn btn-outline-secondary" href="" @click.prevent="editTask(task)"> ИЗМЕНИТЬ</a></td>
                <td><a class="btn btn-outline-danger" href="" @click.prevent="deleteTask(task.id)"> УДАЛИТЬ</a></td>
            </tr>

        </template>
        </tbody>
    </table>
</template>
<script>
export default {
    name: "Create",
    data() {
        return {
            title: null,
            eDit: null,
            status_title: {
                0: 'В РАБОТЕ',
                1: 'ВЫПОЛНЕНО',
            },
            status: null,
            sortType: 0,
            tasks: [],
            editTaskId: null,
        }
    },
    methods: {
        store() {
            axios.post('/api/store', {title: this.title})
                .then(res => {
                    this.getTasks();
                    this.title = '';
                })
        },
        update() {
            axios.patch(`/api/update/${this.editTaskId}`, {title: this.title, status: this.status})
                .then(res => {
                    this.getTasks();
                    this.title = '';
                    this.status = null;
                    this.editTaskId = null;
                })
        },
        getTasks() {
            axios.get('/api/index')
                .then(data => {
                    this.tasks = data.data.data
                })
        },
        deleteTask(id) {
            axios.delete(`/api/delete/${id}`)
                .then(res => {
                    this.getTasks();
                });
        },
        isEdit(id) {
            return this.editTaskId === id
        },
        editTask(task) {
            this.editTaskId = task.id
            this.title = task.title
            this.status = task.status

        },
        updateSort() {
            return this.sortType = (this.sortType === 1) ? 2 : 1;
        },
        getKeyByValue(object, value) {
            return Object.keys(object).find(key => object[key] === value);
        }
    },
    computed: {
        isDisabled() {
            return !this.title;
        },
        sortTasks() {
            if(this.sortType === 0){
                return this.tasks.sort(function (d1, d2) { return (d1.id > d2.id) ? 1 : -1; });
            }else if(this.sortType === 1 && !this.editTaskId){
                this.tasks = this.tasks.sort(function (d1, d2) { return (d1.status < d2.status) ? 1 : -1; });
                return this.tasks.sort(function (d1, d2) { return (d1.status < d2.status) ? 1 : -1; });
            }else if(this.sortType === 2 && !this.editTaskId){
                return this.tasks.sort(function (d1, d2) { return (d1.status > d2.status) ? 1 : -1; });
            }else{
                return this.tasks;
            }
        },

    },
    updated() {
        console.log(this.tasks);
        // this.getTasks();
    },
    mounted() {
        this.getTasks();
    }
}
</script>
<style scoped>

</style>
