<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <router-link class="navbar-brand" to="/">Главная страница</router-link>
                <router-link class="navbar-brand" to="/create">Список задач</router-link>
            </div>
        </nav>
    </div>
    <router-view></router-view>
</template>

<script>

export default {
    name: "Index",
}
</script>

<style scoped>

</style>
