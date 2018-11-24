<script>
    let map;
    function initMap() {
        let uluru = {lat: 15.344, lng: 32.036};

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 15.397, lng: 32.644},
            zoom: 8
        });
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: uluru
        });
        marker.addListener('click', toggleBounce);
        marker.addListener('mouseout', function () {
            let lats = marker.getPosition().lat();
            let lngs = marker.getPosition().lng();
            document.getElementById('latitude').value = lats;
            document.getElementById('longitude').value = lngs;
        })
    }

    function toggleBounce() {
        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtMLK2DhSK0uMol40mlO5dgIPIK3vSIU4&callback=initMap"
        async defer></script>