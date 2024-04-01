<template>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Добавить задачу</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text"></span>
                            <input type="text" class="form-control" v-model="title"
                                   placeholder="введите задачу">
                            <button type="submit" :disabled="isDisabled" class="btn btn-success"
                                    @click.prevent="store()"><i class="bi bi-send"></i> Добавить
                            </button>
                        </div>
                    </td>
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
            <th scope="col" @click.prevent="updateSort()">Статус</th>
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
                <td><a class="btn btn-outline-secondary" href="" @click.prevent="editTask(task)"> ИЗМЕНИТЬ</a></td>
                <td><a class="btn btn-outline-danger" href="" @click.prevent="deleteTask(task.id)"> УДАЛИТЬ</a></td>
            </tr>
            <tr :class="isEdit(task.id) ? '' : 'd-none' ">
                <th scope="row">{{ task.id }}</th>
                <td><input type="text" class="form-control" v-model="title"
                           placeholder="введите задачу" value=""></td>
                <td>
                    <select  class="form-select" name="status" v-model="status">
                        <option v-for="s_title in status_title" :value="getKeyByValue(status_title, s_title)">{{ s_title }}</option>
                    </select>
                </td>
                <td><a class="btn btn-outline-success" href="" @click.prevent="update()">ОБНОВИТЬ</a></td>
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
            status_title: {
                0: 'В РАБОТЕ',
                1: 'ВЫПОЛНЕНО',
            },
            status: null,
            sortType: 1,
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
                    this.tasks = data.data
                })

        },
        deleteTask(id) {
            // console.log(id);
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
            return this.sortType = (this.sortType === 0) ? 1 : 0;
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
                return this.tasks.sort(function (d1, d2) { return (d1.status > d2.status) ? 1 : -1; });
            }else{
                return this.tasks.sort(function (d1, d2) { return (d1.status < d2.status) ? 1 : -1; });
            }
        },

    },
    mounted() {
        this.getTasks();
    }
}
</script>
<style scoped>

</style>
