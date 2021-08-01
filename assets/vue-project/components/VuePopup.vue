<template>
  <div class="popup-box">
    <div class="close_btn">
        <i class="fa fa-times close_popup" @click="closePopup" style="text-align: right"></i>
    </div>
    <div class="form-box">
        <form name="form-auth" @submit.prevent="sendData" class="auth-form">
            <h2>Авторизация</h2>
             <div class="box">
                <input type="text" placeholder="Ведите имя" name="login" v-model.trim="login">
            </div>
              <div class="box">
                <input type="password" placeholder="Ведите пароль" name="password" v-model.trim="password">
            </div>
            <div>
                 <input class="button-form" type="submit" value="Войти">

                <p id="text_error"></p>
                <p id="text_success"></p>
            </div>
        </form>
    </div>
  </div>
</template>

<script>
export default {
    name: 'VuePopup',

    methods:{
        closePopup(){
            this.$emit('closePopup')
        },
        sendData(){
            const data = new FormData(document.forms['form-auth']);
            const requestOptions = {
                method: 'POST',
                body: data
            };
            console.log(data);
            fetch('/maps', requestOptions)
            .then(response => response.json())
            .then(data => {
                if (data.message === 'error') {
                document.getElementById('text_error')
                    .innerText = 'Ошибка регистрации. Пользователь с таким логином уже зарегистрирован.';
                } else if (data.message === 'success_reg') {
                    document.getElementById('text_success')
                        .innerText = 'Авторизация прошла успешно!';
                } 
            })
        }
    }
}
</script>

<style scoped>
    .popup-box{
        padding:20px;
        text-align: center;
        color: #1c1c1c;
    }
    .close_btn{
        text-align: right;
    }
    .form-box{
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
    }
   h2{
      margin-bottom: 32px;
   }
   input{
        border-style: none;
        outline-style: none;
        border: 1px solid #454e54;;
        border-radius: 5px;
        background-color: #fff;
        /* padding-left: 25px; */
        height: 40px;
        width: 100%;
        margin-bottom: 16px;
   }
   .button-form{
      width: 50%;
      margin: 0 25%;
      border: 2px solid rgb(29, 28, 28);
      border-radius: 3px;
      height: 40px;
      background-color: #454e54;
      font-size: 1.3rem;
      font-weight: 600;
      color: #ededed;
      cursor: pointer;
      margin: 16px 0;
   }
   .button-form:hover{
      background-color: #ff9900;
   }
   .unshow{
      display: none;
   }
   #text_success{
      color: green;
   }
    #text_error{
      color: red;
   }
   .close_popup{
       color: #ff9900;
       font-size: 1.3rem;
       font-weight: 500;
       cursor: pointer;
   }
</style>