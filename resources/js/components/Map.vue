<template>
    <div id="map" class="h-96"></div>
</template>

<script>
export default {
    props: ["location"],

    data() {
        return {
            map: null,
            marker: null,
        };
    },
    mounted() {
        const position = {
            lat: this.location.latitude,
            lng: this.location.longitude,
        };
        this.map = new google.maps.Map(document.getElementById("map"), {
            center: position,
            zoom: 18,
        });

        this.marker = new google.maps.Marker({
            position: position,
            map: this.map,
        });
    },
    watch: {
        location: {
            deep: true,
            handler(location) {
                const position = {
                    lat: location.latitude,
                    lng: location.longitude,
                };

                this.marker.setPosition(position);
                this.map.setCenter(position);
            },
        },
    },
};
</script>
