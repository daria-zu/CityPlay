<template>
  <div class="popup-box">
    <div class="close_btn">
        <i class="fa fa-times close_popup" @click="closePopupReview" style="text-align: right"></i>
    </div>
    <div>
       <div class="form-box">
        <form name="form-review" @submit.prevent="sendReview" enctype="multipart/form-data">
            <div class="box">
                <span class="text" for="text">Оценка</span>
                <div class="star-rating">
                    <div class="star-rating__wrap">
                        <input class="star-rating__input" id="star-rating-5" type="radio" name="rating" value="5">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-5" title="5 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-4" type="radio" name="rating" value="4">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-4" title="4 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-3" type="radio" name="rating" value="3">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-3" title="3 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-2" type="radio" name="rating" value="2">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-2" title="2 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-1" type="radio" name="rating" value="1">
                        <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-1" title="1 out of 5 stars"></label>
                    </div> 
                    
                </div>
            </div>
            <div class="box">
                <label class="text" for="text">Отзыв</label>
                <textarea class="textarea" in="text" name="text"/>
            </div>
             <div class="box">
                <span class="text" for="text">Загрузите фото</span>
                <input in="text" type="file" name="photo">
            </div>
            <input class="unshow"  type="text" name="playground_id" :value="index_data">
            <div class="btn_box">
                <input class="button-form" type="submit" value="Отправить"> 
                 
                <p id="text_error"></p>
                <p id="text_success"></p>
            </div>
        </form>
    </div>
    </div>
  </div>
</template>

<script>

export default {
    name: 'VuePopupReview',

    props: {
        index_data:{
            type: Number,
            default: () => []
        }
    },

    methods:{
        closePopupReview(){
            this.$emit('closePopupReview')
        },
        sendReview(){
            const data = new FormData(document.forms['form-review']);
            const requestOptions = {
                method: 'POST',
                body: data
            };
            fetch('/add_review', requestOptions)
            .then(response => response.json())
            .then(data => {
                if (data.message === 'success') {
                    document.getElementById('text_success')
                        .innerText = 'Отзыв добавлен!';
                } else {
                    document.getElementById('text_error')
                    .innerText = 'В данный момент добавление отзывов не осуществляется.';
                }
            })
        }
    }
}
</script>

<style scoped>
    .popup-box{
        padding: 20px 20px 30px 20px;
        text-align: center;
        color: #1c1c1c;
    }
    .close_btn{
        text-align: right;
    }
    .form-box{
        display: flex;
        margin-top: 20px;
    }
   .close_popup{
       color: #ff9900;
       font-size: 1.3rem;
       font-weight: 500;
       cursor: pointer;
   }
   .form-review{
       display: flex;
       flex-direction: column;
       justify-content: space-between;
   }
   .box{
       display: flex;
       flex-direction: row;
       flex-wrap: nowrap;
       margin-bottom: 30px;
   }
   .text{
       width: 140px;
       font-size: 0.9rem;
       padding-right: 20px;
   }
   .btn_box{
       text-align: center;
   }
    .textarea{
        width: 230px;
        border-style: none;
        outline-style: none;
        border: 1px solid #454e54;;
        border-radius: 5px;
        background-color: #fff;
        resize: none;
        height: 130px;
    }
   .button-form{
      width: 50%;
      margin-left: 20px;
      border: 2px solid rgb(29, 28, 28);
      border-radius: 3px;
      height: 40px;
      background-color: #454e54;
      font-size: 1rem;
      font-weight: 600;
      color: #ededed;
      cursor: pointer;
      margin-top: 20px;
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
   .star-rating{
        font-size: 0;
        width: 230px;
    }
    .star-rating__wrap{
        display: inline-block;
        font-size: 1rem;
    }
    .star-rating__wrap:after{
        content: "";
        display: table;
        clear: both;
    }
    .star-rating__ico{
        float: right;
        padding-left: 2px;
        cursor: pointer;
        color: #ff9900;
    }
    .star-rating__ico:last-child{
        padding-left: 0;
    }
    .star-rating__input{
        display: none;
    }
    .star-rating__ico:hover:before,
    .star-rating__ico:hover ~ .star-rating__ico:before,
    .star-rating__input:checked ~ .star-rating__ico:before
    {
        content: "\f005";
    }
</style>