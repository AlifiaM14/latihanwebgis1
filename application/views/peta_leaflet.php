<h1>Nama : Alifia Maharani</h1>
<h1>NIM :11210930000006</h1>

<div class="content">  
<div id="map" style="width: 100%; height: 530px; color:black;"></div>  
</div>  
<script>  

var prov = new L.LayerGroup(); 
var faskes = new L.LayerGroup(); 
var sungai = new L.LayerGroup(); 
var provin = new L.LayerGroup();
var sungaibekasi = new L.LayerGroup();
var administrasidesabekasi = new L.LayerGroup();
var jalanbekasi = new L.LayerGroup();

var map = L.map('map', {  
center: [-1.7912604466772375, 116.42311966554416],  
zoom: 5,  
zoomControl: false,
layers:[]  
});  

var GoogleSatelliteHybrid= L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {  
maxZoom: 22,  
attribution: 'Latihan Web GIS'  
}).addTo(map);

var Esri_NatGeoWorldMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', {
	attribution: 'Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC',
	maxZoom: 16
});

var GoogleMaps = new 
L.TileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { opacity: 1.0,  
attribution: 'Latihan Web GIS'  
}); 
var GoogleRoads = new 
L.TileLayer('https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}',{  
opacity: 1.0,  
attribution: 'Latihan Web GIS'  
}); 

var baseLayers = { 
'Google Satellite Hybrid': GoogleSatelliteHybrid, 
'Esri_NatGeoWorldMap':Esri_NatGeoWorldMap,
'GoogleMaps':GoogleMaps,
'GoogleRoads':GoogleRoads
}; 

var groupedOverlays = { 
"Peta Dasar":{
'Ibu Kota Provinsi' :prov,
'Jaringan Sungai' :sungai,
'Provinsi' :provin,
'sungaibekasi' :sungaibekasi,
'administrasidesabekasi' :administrasidesabekasi,
'jalanbekasi' :jalanbekasi
},  
"Peta Khusus":{'Fasilitas Kesehatan' :faskes}
};

L.control.groupedLayers(baseLayers, groupedOverlays).addTo(map); 

var 
osmUrl='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'; 
 var osmAttrib='Map data &copy; OpenStreetMap contributors';  
var osm2 = new L.TileLayer(osmUrl, {minZoom: 0, maxZoom: 13, attribution: osmAttrib });  
var rect1 = {color: "#ff1100", weight: 3};  
var rect2 = {color: "#0000AA", weight: 1, opacity:0, fillOpacity:0};  
var miniMap = new L.Control.MiniMap(osm2, {toggleDisplay: true, position : "bottomright", 
aimingRectOptions : rect1, shadowRectOptions: rect2}).addTo(map); 

L.Control.geocoder({position :"topleft", collapsed:true}).addTo(map);

/* GPS enabled geolocation control set to follow the user's location */
var locateControl = L.control.locate({
position: "topleft",
drawCircle: true,
follow: true,
setView: true,
keepCurrentZoomLevel: true,
markerStyle: {
weight: 1,
opacity: 0.8,
fillOpacity: 0.8
},
circleStyle: {
weight: 1,
clickable: false
},
icon: "fa fa-location-arrow",
metric: false,
strings: {
title: "My location",
popup: "You are within {distance} {unit} from this point",
outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
},
locateOptions: {
maxZoom: 18,
watch: true,
enableHighAccuracy: true,
maximumAge: 10000,
timeout: 10000
}
}).addTo(map);

var zoom_bar = new L.Control.ZoomBar({position: 'topleft'}).addTo(map); 

L.control.coordinates({  
position:"bottomleft",  
decimals:2,  
decimalSeperator:",",  
labelTemplateLat:"Latitude: {y}",  
labelTemplateLng:"Longitude: {x}"  
}).addTo(map); 
/* scala */ 
L.control.scale({metric: true, position: "bottomleft"}).addTo(map); 

var north = L.control({position: "bottomleft"});  
north.onAdd = function(map) {  
var div = L.DomUtil.create("div", "info legend");  
div.innerHTML = '<img src="<?=base_url()?>assets/arah-mata-angin.png"style=width:200px;>';  
return div; }  
north.addTo(map); 

$.getJSON("<?=base_url()?>assets/provinsi.geojson",function(data){  
var ratIcon = L.icon({  
iconUrl: '<?=base_url()?>assets/Marker-1.png',  
iconSize: [12,10]  
});  
L.geoJson(data,{  
pointToLayer: function(feature,latlng){  
var marker = L.marker(latlng,{icon: ratIcon});  
marker.bindPopup(feature.properties.CITY_NAME);  
return marker;  
}  
}).addTo(prov);  
}); 

$.getJSON("<?=base_url()?>assets/rsu.geojson",function(data){  
var ratIcon = L.icon({  
iconUrl: '<?=base_url()?>assets/Marker-3.png',  
iconSize: [12,10]  
});  
L.geoJson(data,{  
pointToLayer: function(feature,latlng){  
var marker = L.marker(latlng,{icon: ratIcon});  
marker.bindPopup(feature.properties.NAMOBJ);  
return marker;  
}  
}).addTo(faskes);  
}); 

$.getJSON("<?=base_url()?>assets/poliklinik.geojson",function(data){  
  var ratIcon = L.icon({  
   iconUrl: '<?=base_url()?>assets/Marker-4.png',  
   iconSize: [12,10]  
  });  
  L.geoJson(data,{  
   pointToLayer: function(feature,latlng){  
    var marker = L.marker(latlng,{icon: ratIcon});  
    marker.bindPopup(feature.properties.NAMOBJ);  
    return marker;  
   }  
  }).addTo(faskes);  
 }); 

$.getJSON("<?=base_url()?>assets/puskesmas.geojson",function(data){ 
   var ratIcon = L.icon({  
   iconUrl: '<?=base_url()?>assets/Marker-5.png',  
   iconSize: [12,10]  
  });  
  L.geoJson(data,{  
   pointToLayer: function(feature,latlng){  
    var marker = L.marker(latlng,{icon: ratIcon});  
    marker.bindPopup(feature.properties.NAMOBJ);  
    return marker;  
   }  
  }).addTo(faskes);  
 }); 

 $.getJSON("<?=base_url()?>/assets/sungai.geojson",function(kode){  
L.geoJson( kode, {  
style: function(feature){  
var color,  
kode = feature.properties.kode;  
if ( kode < 2 ) color = "#f2051d";  
else if ( kode > 0 ) color = "#f2051d";  
else color = "#f2051d"; // no data  
return { color: "#999", weight: 5, color: color, fillOpacity: .8 };  
},  
onEachFeature: function( feature, layer ){  
layer.bindPopup  
()  
} }).addTo(sungai);  
}); 

//sungai bekasi
$.getJSON("<?=base_url()?>/assets/sungaibekasi.geojson",function(kode){  
L.geoJson( kode, {  
style: function(feature){  
var color,  
kode = feature.properties.kode;  
if ( kode < 2 ) color = "#fcc737";  
else if ( kode > 0 ) color = "#fcc73";  
else color = "#fcc73"; // no data  
return { color: "#999", weight: 5, color: color, fillOpacity: .8 };  
},  
onEachFeature: function( feature, layer ){  
layer.bindPopup  
()  
} }).addTo(sungaibekasi);  
});

//administrasi desa bekasi
$.getJSON("<?=base_url()?>/assets/administrasidesabekasi.geojson",function(kode){  
L.geoJson( kode, {  
style: function(feature){  
var color,  
kode = feature.properties.kode;  
if ( kode < 2 ) color = "#f26b0f";  
else if ( kode > 0 ) color = "#f26b0f";  
else color = "#f26b0f"; // no data  
return { color: "#999", weight: 5, color: color, fillOpacity: .8 };  
},  
onEachFeature: function( feature, layer ){  
layer.bindPopup  
()  
} }).addTo(administrasidesabekasi);  
});

var markersDataAlfamart = [
	{
    coords: [-6.321389, 107.000233],
    popupText: "<b>Alfamart 1</b><br>Alamat : Perumahan vida Bekasi No. 6&8, RT.003/RW.016 Fasilitas : Tempat Duduk, ATM Link, Toilet, dan Tempat Parkir<br><br><img src='assets/Alfa(1).jpg' alt='Image 3' style='width:100%;'/><br>."
  },

  {
    coords: [-6.314792, 106.997841],
    popupText: "<b>Alfamart 2</b><br>Alamat : Jl. Bantar Gebang Setu, RT.002/RW.002 Fasilitas : Tempat Parkir<br><br><img src='assets/Alfa(2).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.325153, 107.004314],
    popupText: "<b>Alfamart 3</b><br>Alamat : Jl. Macem, RT.001/RW.005 Fasilitas : Kursi Duduk, Tempat Parkir, dan ATM Link<br><br><img src='assets/Alfa(3).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.329583, 107.003462],
    popupText: "<b>Alfamart 4</b><br>Alamat : Jl. Kp. Cibitung, RT.003/RW.004 Fasilitas : Tempat Parkir, ATM Link, dan ATM Aladin<br><br><img src='assets/Alfa(4).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.323581, 107.015450],
    popupText: "<b>Alfamart 5</b><br>Alamat : Jalan Raya Bekasi Timur Regensi e2 16, RT.010/RW.016 Fasilitas : ATM (BCA, BRI, MANDIRI, ATM Link) dan Tempat Parkir<br><br><img src='assets/Alfa(5).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.326011, 107.010889],
    popupText: "<b>Alfamart 6</b><br>Alamat : Perum, Jl. Raya Bekasi Timur Regensi Ruko Cluster Garnet No.10 - 11, RT.004/RW.006 Fasilitas : Tempat Parkir<br><br><img src='assets/Alfa(6).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.327016, 107.018431],
    popupText: "<b>Alfamart 7</b><br>Alamat : Jl. Raya Bekasi Timur Regensi No.7, RT.001/RW.008 Fasilitas : Tempat Parkir<br><br><img src='assets/Alfa(7).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.321875, 107.017880],
    popupText: "<b>Alfamart 8</b><br>Alamat : Jl. Raya Bekasi Timur Regensi, RT.003/RW.020 Fasilitas : ATM Link & Tempat Parkir<br><br><img src='assets/Alfa(8).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.321027, 107.016927],
    popupText: "<b>Alfamart 9</b><br>Alamat : Jl. Zamrud Utara, RT.003/RW.017 Fasilitas : ATM Link, Tempat Parkir, dan Kursi Duduk<br><br><img src='assets/Alfa(9).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.315825, 107.020930],
    popupText: "<b>Alfamart 10</b><br>Alamat : Perum Dukuh Zamrud Blok F, RT.002/RW.021 Fasilitas : ATM Mandiri, ATM Link, dan Tempat Parkir<br><br><img src='assets/Alfa(10).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.308697, 107.026232],
    popupText: "<b>Alfamart 11</b><br>Alamat : Perum Dukuh Zamrud Blok U16 No.106, RT.006/RW.010 Fasilitas : Tempat Parkir<br><br><img src='assets/Alfa(11).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.309889, 107.022761],
    popupText: "<b>Alfamart 12</b><br>Alamat : Jl. Zamrud Utara, RT.001/RW.020 Fasilitas : Kursi Duduk, Toilet, dan ATM Link<br><br><img src='assets/Alfa(12).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.306946, 107.017105],
    popupText: "<b>Alfamart 13</b><br>Alamat : Jl. Klp. Dua No.12, RT.002/RW.008 Fasilitas : ATM Link dan Tempat Parkir<br><br><img src='assets/Alfa(13).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.302927, 107.019206],
    popupText: "<b>Alfamart 14</b><br>Alamat : Jl. Raya Asem Jaya, RT.002/RW.006 Fasilitas : Tempat Parkir<br><br><img src='assets/Alfa(14).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.303384, 107.024089],
    popupText: "<b>Alfamart 15</b><br>Alamat : Jl. Graha Harapan No.1 Blok A 10, RT.001/RW.019 Fasilitas : ATM Link dan Tempat Parkir<br><br><img src='assets/Alfa(15).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.297854, 107.025188],
    popupText: "<b>Alfamart 16</b><br>Alamat : Jl. Bayan 1 G No.3 Blok G No, RT.004/RW.023 Fasilitas : Kursi Duduk, Tempat Parkir, dan ATM Link<br><br><img src='assets/Alfa(16).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.312947, 107.010664],
    popupText: "<b>Alfamart 17</b><br>Alamat : Jl. Klp. Dua No.31, RT.002/RW.2 Fasilitas : ATM BRI dan Tempat Parkir<br><br><img src='assets/Alfa(17).jpg' alt='Image 3' style='width:100%;'/><br>."
  },
  {
    coords: [-6.316650, 107.009339],
    popupText: "<b>Alfamart 18</b><br>Alamat : Jl. Bantar Gebang Setu No.27, RT.001/RW.007 Fasilitas : ATM BCA dan Tempat Parkir<br><br><img src='assets/Alfa(18).jpg' alt='Image 3' style='width:100%;'/><br>."
  }
];

markersDataAlfamart.forEach(function(marker) {
  var newMarker = L.marker(marker.coords).addTo(administrasidesabekasi);
  newMarker.bindPopup(marker.popupText).openPopup();
});


//jalan bekasi
$.getJSON("<?=base_url()?>/assets/jalanbekasi.geojson",function(kode){  
L.geoJson( kode, {  
style: function(feature){  
var color,  
kode = feature.properties.kode;  
if ( kode < 2 ) color = "#e73879";  
else if ( kode > 0 ) color = "#e73879";  
else color = "#e73879"; // no data  
return { color: "#999", weight: 5, color: color, fillOpacity: .8 };  
},  
onEachFeature: function( feature, layer ){  
layer.bindPopup  
()  
} }).addTo(jalanbekasi);  
});



$.getJSON("<?=base_url()?>/assets/provinsi_poligon.geojson",function(kode){ 
    L.geoJson( kode, { 
      style: function(feature){ 
        var fillColor, 
            kode = feature.properties.kode; 
        if ( kode > 21 ) fillColor = "#006837";       
        else if (kode>20) fillColor="#fec44f" 
        else if (kode>19) fillColor="#c2e699" 
        else if (kode>18) fillColor="#fee0d2" 
        else if (kode>17) fillColor="#756bb1" 
        else if (kode>16) fillColor="#8c510a" 
        else if (kode>15) fillColor="#01665e" 
        else if (kode>14) fillColor="#e41a1c" 
        else if (kode>13) fillColor="#636363" 
        else if (kode>12) fillColor= "#762a83" 
        else if (kode>11) fillColor="#1b7837" 
        else if (kode>10) fillColor="#d53e4f" 
        else if (kode>9) fillColor="#67001f" 
        else if (kode>8) fillColor="#c994c7" 
        else if (kode>7) fillColor="#fdbb84" 
        else if (kode>6) fillColor="#dd1c77" 
        else if (kode>5) fillColor="#3182bd" 
        else if ( kode > 4 ) fillColor ="#f03b20" 
        else if ( kode > 3 ) fillColor = "#31a354"; 
        else if ( kode > 2 ) fillColor = "#78c679"; 
        else if ( kode > 1 ) fillColor = "#c2e699"; 
        else if ( kode > 0 ) fillColor = "#ffffcc"; 
        else fillColor = "#f7f7f7";  // no data 
        return { color: "#999", weight: 1, fillColor: fillColor, fillOpacity: .6 }; 
      }, 
      onEachFeature: function( feature, layer ){ 
        layer.bindPopup(feature.properties.PROV) 
      } 
    }).addTo(provin); 
  }); 

</script> 