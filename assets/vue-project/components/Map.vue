<template>
<div>

  <vue-popup class="vue-popup" v-if="popupVisible" @closePopup="closePopup"/>

 <div class="header">
       <div class="box">
          <router-link to="/map" class="home">
                <i class="fa fa-home"></i>
          CityPlay</router-link>
      </div>
      <div class="box">

           <a class="reg" @click="showPopup">
                <i class="fa fa-user"></i>
           Войти/Регистрация</a>
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
            v-for="marker in markerLatLng" 
            :key="marker.index"  
            :lat-lng="[marker.possitionY,marker.possitionX]" 
            @click="openPopUp(marker.possitionY,marker.possitionX)"
            :icon="icon"
           >
                <l-popup class="popup">
                    <!-- <p>{{marker.id}}</p> -->
                    <div v-if="marker.image">
                      <!-- <a @click="showPopupImage"> -->
                        <img class="img-playground" :src="require('../../../public/images/' + marker.image)">
                      <!-- </a>
                      <vue-popup-image class="vue-popup-image" :marker_data="marker.image" v-if="popupImageVisible"/> -->
                    </div>
                    <!-- <div v-else>
                      <img class="img-playground" src="../../../public/images/default-image.png">
                    </div> -->
                    <div class="rating">

                    </div>
                    <div class="review">
                      <a>Отзывы</a>
                      <a @click="showPopupReview">Оставить отзыв</a>
                      <vue-popup-review class="vue-popup-review" :index_data="marker.id" v-if="popupReviewVisible" @closePopupReview="closePopupReview"/>
                    </div>
                </l-popup>
                <!-- <vue-popup-review class="vue-popup-review" :index_data="marker.id" v-if="popupReviewVisible" @closePopupReview="closePopupReview"/> -->
            </l-marker>
        </l-map>
    </div>
    <router-view></router-view>
</div>
</template>

// <script>
import L from 'leaflet';
import { LMap, LTileLayer, LMarker, LPopup, LTooltip, LIcon} from 'vue2-leaflet';
import marker from '../../marker-icon.png';
import VuePopup from './VuePopup.vue';
import VuePopupImage from './VuePopupImage.vue';
import VuePopupReview from './VuePopupReview.vue';

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
    VuePopupReview
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
        popupImageVisible: false,
        popupReviewVisible: false,
    }
  },

   created() {
    fetch('/maps')
      .then(response => response.json())
      .then(json => this.markerLatLng = json.playgrounds);
   },

   methods: {
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
    showPopup(){
      this.popupVisible = true
    },
    closePopup(){
      this.popupVisible = false
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
    }
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
        padding: 10px;
        height: 220px;
        width: 180px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
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
    }
    .vue-popup-image{
      background: #fffafa;
      z-index: 100;
      position: absolute;
      margin: auto;
      top: 0;
      bottom: 0;
      right: 0;
      left: 0;
      box-shadow: 0 0 10px 0 #e7e7e7;
    }
    .review{
      display: flex;
      justify-content: space-between;
    }
    .review a{
      display: inline-block;
      text-decoration: none;
      color: #ff9900;
      cursor: pointer;
      font-size: 0.8rem;
    }
    .vue-popup-review{
      background: #fffafa;
      z-index: 100;
      height: 380px;
      width: 430px;
      position: absolute;
      margin: auto;
      top: 0;
      bottom: 0;
      right: 0;
      left: 0;
      box-shadow: 0 0 10px 0 #e7e7e7;
      padding-left: 20px;
    }
</style>