<template>
<div>

  <vue-popup class="vue-popup" v-if="popupVisible" @closePopup="closePopup" @sendAuth="getAuthMessage"/>
  <vue-popup-reg class="vue-popup" v-if="popupRegVisible" @closePopupReg="closePopupReg"/>

 <div class="header">
       <div class="box">
          <router-link to="/map" class="home">
                <i class="fa fa-home"></i>
          CityPlay</router-link>
      </div>
      <div v-if="!authorization" class="wrap">
        <div class="box">
        <a class="reg" @click="showPopup">
          <i class="fa fa-user"></i>
          Войти
        </a>
        </div>
        <div class="box">
          <a class="reg" @click="showPopupReg">Регистрация</a>
        </div>
      </div>
      <div  v-if="authorization" class="box">
        <a class="reg" @click="logout">
             <i class="fa fa-user"></i>
             Выйти
           </a>
      </div>  
           
      
    </div>
    <div class="map">
        <l-map   
        :zoom="zoom"
        :center="center"
        @update:zoom="zoomUpdated"
        @update:center="centerUpdated"
        @update:bounds="boundsUpdated"
        >
            <l-tile-layer :url="url"></l-tile-layer>
            <l-marker 
            @mousedown="getReviews(marker.id)"
            v-for="marker in markerLatLng" 
            :key="marker.index"  
            :lat-lng="[marker.possitionY,marker.possitionX]" 
            @click="openPopUp(marker.possitionY,marker.possitionX)"
            :icon="icon"
            >
                <l-popup>
                  <div class="popup">
                    <div v-if="marker.image">
                        <img class="img-playground" :src="require('../../../public/images/' + marker.image)">
                    </div>
                    <div v-else>
                      <img class="img-playground" src="../../ default-image.png">
                    </div>
                    <div class="rating">
                      <star-rating class="stars" :increment="0.01" :fixed-points="2" :read-only="true" :star-size="20" :rating="marker.rating"></star-rating>
                    </div>
                    <div class="review separator">
                          <h2>Отзывы</h2>
                      <div class="reviews">
                        <div v-if="reviewlist.length">
                          <div class="review-box" v-for="review in reviewlist" :key="review.index">
                            <p class="review-text">{{review.text}}</p>
                          </div>
                        </div>
                        <div v-else>
                          <p>Здесь пока нет ни одного отзыва</p>
                        </div>
                      </div>
                      <div>
                        <a @click="showPopupReview" class="review-href">Оставить отзыв</a>
                        <vue-popup-review class="vue-popup-review" :index_data="marker.id" v-if="popupReviewVisible" @closePopupReview="closePopupReview"/>
                      </div>
                
                    </div>
                  </div>
                </l-popup>
            </l-marker>
        </l-map>
    </div>
    <router-view></router-view>
</div>
</template>

<script>
import L from 'leaflet';
import { LMap, LTileLayer, LMarker, LPopup, LIcon} from 'vue2-leaflet';
import marker from '../../marker-icon.png';
import VuePopup from './VuePopup.vue';
import VuePopupReg from './VuePopupReg.vue';
import VuePopupImage from './VuePopupImage.vue';
import VuePopupReview from './VuePopupReview.vue';
import StarRating from 'vue-star-rating';

export default {
  name: "Map",
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
    LIcon,
    VuePopup,
    VuePopupImage,
    VuePopupReview,
    StarRating,
    VuePopupReg
  },

  data () {
    return {
        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        zoom: 14.5,
        center: [59.926967, 30.296899],
        icon: L.icon({
            iconUrl: marker
        }),
        markerLatLng: [],
        popupVisible: false,
        popupRegVisible: false,
        popupImageVisible: false,
        popupReviewVisible: false,
        reviewlist: [],
        authorization: false,
    }
  },

   created() {
    //  getting marker's x,y possition
    fetch('/maps')
      .then(response => response.json())
      .then(json => this.markerLatLng = JSON.parse(json.playgrounds));
    
    // checking authorization
    setInterval(async () => {
      const f = await fetch('/checkauth');
      const data = await f.json();
      this.authorization = data.message;
    }, 600000);

   },

   methods: {
     // leaflet methods
    zoomUpdated (zoom) {
      this.zoom = zoom;
    },
    centerUpdated (center) {
      this.center = center;
    },
    boundsUpdated (bounds) {
      this.bounds = bounds;
    },
    openPopUp (latLng) {
       this.$refs.features.mapObject.openPopup(latLng);
    },
    // methods for open/close popup
    showPopup(){
      this.popupVisible = true;
    },
    closePopup(){
      this.popupVisible = false;
      this.authorization = true;
      console.log('auth_true');
    },
    showPopupReg(){
      this.popupRegVisible = true;
    },
    closePopupReg(){
      this.popupRegVisible = false
    },
    showPopupImage(){
      this.popupImageVisible = true
    },
    closePopupImage(){
      this.popupImageVisible = false
    },
    showPopupReview(){
      this.popupReviewVisible = true
    },
    closePopupReview(){
      this.popupReviewVisible = false
    },
    // method for getting reviews for current marker
    getReviews(id){
      const data = {'index': id};
      fetch('/review/list?index=' + id)
      .then(response => response.json())
      .then(json => this.reviewlist = JSON.parse(json.reviews));
    },
    // method for logout
    logout(){
      this.authorization = false;
      fetch('/logout')
    },
  },


}
</script>

<style scoped>
    .map{
        height: 100vh;
        position: relative;
        z-index: 10;
    }
    .popup{
        text-align: center;
        padding: 10px 20px 10px 0;
        height: 450px;
        width: 300px;
        position: relative;
    }
    .wrap{
      display: flex;
      flex-direction: row;
      flex-wrap: nowrap;
    }
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
        cursor: pointer;
    }
    .vue-popup{
      background: #fffafa;
      z-index: 100;
      width: 360px;
      height: 320px;
      position: absolute;
      margin: auto;
      top: 0;
      bottom: 0;
      right: 0;
      left: 0;
      box-shadow: 0 0 10px 0 #e7e7e7;
    }
    .img-playground{
      width: 100%;
      padding-right: 10px;
      height: 230px;
    }
    .vue-popup-image{
      background: #fffafa;
      width: 800px;
      z-index: 100;
      position: absolute;
      margin: auto;
      top: 0;
      bottom: 0;
      right: 0;
      left: 0;
      box-shadow: 0 0 10px 0 #e7e7e7;
    }
    .rating{
      padding: 5px 0 0 0;
    }
    .separator::before{
      content: "";
      display: inline-block;
      width: 140px;  
      height: 2px;
      background-color: #ff9900
    }
     .separator_thin::before{
      content: "";
      display: inline-block;
      width: 280px;  
      height: 1px;
      background-color: #ff9900
    }
    .review-text{
      margin: 0;
      padding: 0;
    }
    .reviews{
      height: 80px;
      display: flex;
      flex-direction: column;
      flex-wrap: nowrap;
      overflow-y: auto;
      padding: 5px 0 20px 0;
    }
    .review-box{
      border-radius: 10px;
      margin-bottom: 10px;
      padding: 5px 10px;
      background: #F5F5F5;
    }
    .review-href{
      display: inline-block;
      text-align: center;
      text-decoration: none;
      color: #ff9900;
      cursor: pointer;
      margin-top: 15px;
      text-align: right;
      font-size: 0.8rem;
    }
    h2{
      margin-bottom: 10px;
      color: #1c1c1c;
      cursor: pointer;
      margin-bottom: 5;
    }
     .vue-popup-review{
      background: #fffafa;
      z-index: 100;
      height: 390px;
      width: 440px;
      position: absolute;
      margin: auto;
      top: 0;
      bottom: 0;
      right: 0;
      left: 0;
      box-shadow: 0 0 10px 0 #e7e7e7;
      padding-left: 20px;
    }
    .unshow{
      display: none;
    }
</style>