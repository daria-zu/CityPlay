<template>
  <div>
    <vue-header></vue-header>
   
    <router-view></router-view>
  </div>
</template>

<script>
import VueHeader from './components/VueHeader.vue';
export default {
  components: {VueHeader},
  name: "App",
}
</script>

<style>
  *{
    margin: 0;
  }
</style>