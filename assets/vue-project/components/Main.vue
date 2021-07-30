<template>
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
                    <!-- <i class="fa fa-map-pin marker"></i> -->
                    <!-- <i class="fa fa-thumb-tack marker"></i> -->
                </l-icon>
                <!-- <l-tooltip>{{marker.description}}</l-tooltip> -->
                <l-popup class="popup">
                    <img src="#">
                    <p>{{marker.discription}}</p>
                </l-popup>
            </l-marker>

        </l-map>
    </div>
</template>

// <script>
// import L from 'leaflet';
import { LMap, LTileLayer, LMarker, LPopup, LTooltip, LIcon} from 'vue2-leaflet';
// import marker from '../../marker-icon.png';

export default {
  name: "Main",
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
        markerLatLng: [
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

</style>