<template>
  <div class="popup-box">
    <div class="close_btn">
        <i class="fa fa-times close_popup" @click="closePopupImage" style="text-align: right"></i>
    </div>
    <div class="box-image">
        <img :src="require('../../../public/images/' + marker_data)">
    </div>
  </div>
</template>

<script>
export default {
    name: 'VuePopupImage',
    props: {
        marker_data:{
            type: Object,
            default: () => []
        }
    },

    methods:{
        closePopupImage(){
            this.$emit('closePopupImage')
        },
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
    }
   .close_popup{
       color: #ff9900;
       font-size: 1.3rem;
       font-weight: 500;
       cursor: pointer;
   }
   img{
       width: 100%;
   }
</style>