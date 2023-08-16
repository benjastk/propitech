$(document).ready(function(){
    var direccion = $("#direccion").val();
    $('#direccion, #numero, #idPais, #idRegion, #idProvincia, #idComuna').change(function(){
        var direccion = $("#direccion").val();
        var numero = $("#numero").val();
        var pais = $("#idPais option:selected").html();
        var region = $("#idRegion option:selected").html();
        var provincia = $("#idProvincia option:selected").html();
        var comuna = $("#idComuna option:selected").html();
        var direccionEnviar = "" + direccion + " " + numero + " " + comuna + " " + region + " " + pais + " ";
        if(direccion){
            $.ajax({
                url: '/api/maps/' + direccionEnviar,
                method:'GET',
                dataType: 'json',
                success: function (respuesta) {
                    console.log(respuesta);
                    document.getElementById("latitud").value = respuesta['features']['0']['geometry']['coordinates']['1'];
                    document.getElementById("longitud").value = respuesta['features']['0']['geometry']['coordinates']['0'];
                    mapboxgl.accessToken = 'pk.eyJ1IjoiYmVuamFzdGsiLCJhIjoiY2xnZHYwZ2V0MG82MjNscnl6dXQxZWxsaiJ9.wLKdL8bv-Y9DKI8qSW_AZw';
                    var map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/streets-v11',
                        center: [respuesta['features']['0']['geometry']['coordinates']['0'], respuesta['features']['0']['geometry']['coordinates']['1']],
                        zoom: 17
                    });
                    let marker1 = new mapboxgl.Marker()
                    .setLngLat([respuesta['features']['0']['geometry']['coordinates']['0'], respuesta['features']['0']['geometry']['coordinates']['1']])
                    marker1.addTo(map);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    });
    if(direccion != '')
    {
        var direccion = $("#direccion").val();
        var numero = $("#numero").val();
        var pais = $("#idPais option:selected").html();
        var region = $("#idRegion option:selected").html();
        var provincia = $("#idProvincia option:selected").html();
        var comuna = $("#idComuna option:selected").html();
        var direccionEnviar = "" + direccion + " " + numero + " " + comuna + " " + provincia + " " + region + " " + pais + " ";
        if(direccion){
            $.ajax({
                url: '/api/maps/' + direccionEnviar,
                method:'GET',
                dataType: 'json',
                success: function (respuesta) {
                    console.log(respuesta);
                    document.getElementById("latitud").value = respuesta['features']['0']['geometry']['coordinates']['1'];
                    document.getElementById("longitud").value = respuesta['features']['0']['geometry']['coordinates']['0'];
                    mapboxgl.accessToken = 'pk.eyJ1IjoiYmVuamFzdGsiLCJhIjoiY2xnZHYwZ2V0MG82MjNscnl6dXQxZWxsaiJ9.wLKdL8bv-Y9DKI8qSW_AZw';
                    var map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/streets-v11',
                        center: [respuesta['features']['0']['geometry']['coordinates']['0'], respuesta['features']['0']['geometry']['coordinates']['1']],
                        zoom: 17
                    });
                    let marker1 = new mapboxgl.Marker()
                    .setLngLat([respuesta['features']['0']['geometry']['coordinates']['0'], respuesta['features']['0']['geometry']['coordinates']['1']])
                    marker1.addTo(map);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    }
});

