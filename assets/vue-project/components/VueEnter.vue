<template>
  <div>
      <router-link class="slogan" to="/map">CityPlay</router-link>
    <router-view></router-view>
  </div>
</template>

<script>

export default {
  name: "VueEnter",
}
</script>

<style>

  .slogan{
    text-align: center;
    text-decoration: none;
    font-size: 9rem;
    font-weight: 700;
    line-height: 100vh;
    color: #ff9900;
    cursor: pointer;
    padding: 0 36%;
  }

</style>