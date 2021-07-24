<template>
  <div>
    <p>Тут будет карта</p>
    <router-link to="/registration">Войти</router-link>
   
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: "App",
}
</script>

<style scoped>

</style>