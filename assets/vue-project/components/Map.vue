<template>
<div>
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
            :lat-lng="marker.possition" 
            @click="openPopUp(marker.possition)"
           >
                <l-icon>
                    <i class="fa fa-map-marker marker"></i>
                </l-icon>
                <!-- <l-tooltip>{{marker.description}}</l-tooltip> -->
                <l-popup class="popup">
                    <img src="#">
                    <p>{{marker.discription}}</p>
                </l-popup>
            </l-marker>
        </l-map>
    </div>
    <router-view></router-view>
</div>
</template>

// <script>
// import L from 'leaflet';
import { LMap, LTileLayer, LMarker, LPopup, LTooltip, LIcon} from 'vue2-leaflet';

export default {
  name: "Map",
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
    LTooltip,
    LIcon
  },

  data () {
    return {
        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        zoom: 13,
        center: [59.942124, 30.284749],
        // icon: L.icon({
        //     iconUrl: marker
        // }),
        markerLatLng: [,
            {index:1,
            possition: [59.942124, 30.284749],
            discription: "Точка1"},
            {index:2,
            possition: [59.942459, 30.248302],
            discription: "Точка2"
            }
        ] 

    }
  },

   created() {
    fetch('/map')
      .then(response => response.json())
      .then(json => this.markerLatLng = JSON.parse(json.playgrounds));
      // console.log(this.markerLatLng);
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

    computed:{
      getPossition(){
        for(marker of this.markerLatLng){
          let possitionXY = [];
          marker.splice(marker.possitionY);
          marker.splice(marker.possitionX);
          marker.possition = possitionXY;
        }
        // console.log(this.markerLatLng)

      }
    }
  }
}
</script>

<style scoped>
    .map{
        height: 100vh;
    }

    .marker{
        font-size: 3rem;
        color: #ff6a00;
    }

    .popup{
        text-align: center;
        padding: 10px;
        height: 200px;
        width: 160px;
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
    }

</style>