<x-front-layout title="Order Details">

    <x-slot:breadcrumbs>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Order # {{$order->number}}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="">Orders</a></li>
                            <li>Order # {{$order->number}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot:breadcrumbs>
    <!--====== Checkout Form Steps Part Start ======-->

    <section class="checkout-wrapper section">
        <div class="container">
            <div id="map"></div>
        </div>
    </section>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
    var map, marker;
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('7a33473050559457695c', {
            cluster: 'ap2',
            channelAuthorization: {
                endpoint: "/broadcasting/auth",
                headers: {
                    "X-CSRF-Token": "{{ csrf_token() }}"
                }
            }
        });

        var channel = pusher.subscribe('private-deliveries.{{$order->id}}');
        channel.bind('location-updated', function(data) {
            marker.setPosition({
                lat: Number("{{ $delivery->lat }}"),
                lng: Number("{{ $delivery->lng }}")
            })
        });
    </script>
    <script>
        // Initialize and add the map
        function initMap() {
            // The location of Delivery
            const location = {
                lat: Number("{{ $delivery->lat }}"),
                lng: Number("{{ $delivery->lng }}")
            };
            // The map, centered at Uluru
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: location,
            });
            // The marker, positioned at Uluru
            marker = new google.maps.Marker({
                position: location,
                map: map,
            });
        }

        window.initMap = initMap;
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNsow1Krqsy2G3ZaVntqjEPQDAUcSNcko&callback=initMap&v=weekly" defer></script>
</x-front-layout>
