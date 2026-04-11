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
                    //document.getElementById("latitud").value = respuesta['results'][0]['geometry']['location']['lat'];
                    //document.getElementById("longitud").value = respuesta['results'][0]['geometry']['location']['lng'];
                    document.getElementById("latitud").value = respuesta[0]['lat'];
                    document.getElementById("longitud").value = respuesta[0]['lon'];
                    var map;
                    var latlng = new google.maps.LatLng( respuesta[0]['lat'] , respuesta[0]['lon']);
                    map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 14,
                        center: latlng,
                        streetViewControl: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        disableDefaultUI: true
                    });
                    var myLatlng = new google.maps.LatLng( respuesta[0]['lat'] , respuesta[0]['lon']);
                    var marker = new google.maps.Marker({
                        position: myLatlng
                    });
                    marker.setMap(map);
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
                    console.log(respuesta[0]['lat']);
                    //document.getElementById("latitud").value = respuesta['results'][0]['geometry']['location']['lat'];
                    //document.getElementById("longitud").value = respuesta['results'][0]['geometry']['location']['lng'];
                    document.getElementById("latitud").value = respuesta[0]['lat'];
                    document.getElementById("longitud").value = respuesta[0]['lon'];
                    var latlng = new google.maps.LatLng( respuesta[0]['lat'] , respuesta[0]['lon']);
                    map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 14,
                        center: latlng,
                        streetViewControl: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        disableDefaultUI: true
                    });
                    var myLatlng = new google.maps.LatLng( respuesta[0]['lat'] , respuesta[0]['lon']);
                    var marker = new google.maps.Marker({
                        position: myLatlng
                    });
                    marker.setMap(map);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    }
});

