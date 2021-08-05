<template>
    <div class="header">
      <div class="box">
          <router-link to="/" class="home">
                <i class="fa fa-home"></i>
          CityPlay</router-link>
      </div>
      <div class="box">

           <router-link class="reg" to="/registration">
                <i class="fa fa-user"></i>
           Войти/Регистрация</router-link>
      </div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "VueHeader",
}
</script>

<style scoped>
    .box:hover{
        background-color: #fff;
    }
    .box:hover .home{
        color: #ff9900;
    }
    .box:hover .reg{
        color: #ff9900;
    }
    .header{
        display: flex;
        justify-content: space-between;
        background: #ff9900;
        height: 4rem;
        padding: 0 3rem;
    }
    .home, .reg{
        margin: 0;
        padding: 2rem;
        line-height: 4rem;
        color: #fff;
        font-size: 1.7rem;
        text-decoration: none;
    }
    .reg{
        font-size: 1.7rem;
    }
</style>