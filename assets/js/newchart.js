/*
 *  Document   : index2.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Dashboard 2 page
 */

var Index2 = function() {

    return {
        init: function() {
 

            /*
             * With Gmaps.js, Check out examples and documentation at http://hpneo.github.io/gmaps/examples.html
             */

            // Initialize Timeline map
            /*new GMaps({
                div: '#gmap-timeline-dash2',
                lat: -33.863,
                lng: 151.202,
                zoom: 15,
                disableDefaultUI: true,
                scrollwheel: false
            }).addMarkers([
                {
                    lat: -33.863,
                    lng: 151.202,
                    animation: google.maps.Animation.DROP,
                    infoWindow: {content: '<strong>Cafe-Bar: Example Address</strong>'}
                }
            ]);*/

            /*
             * Flot Jquery plugin is used for charts
             *
             * For more examples or getting extra plugins you can check http://www.flotcharts.org/
             * Plugins included in this template: pie, resize, stack, time
             */

            // Get the element to init
            var chartLive = $('#dash-chart-live');

            // Live Chart
            var dataLive = [];

            // Random data generator
            function getRandomData() {

                if (dataLive.length > 0)
                    dataLive = dataLive.slice(1);

                while (dataLive.length < 300) {
                    var prev = dataLive.length > 0 ? dataLive[dataLive.length - 1] : 50;
                    var y = prev + Math.random() * 10 - 5;
                    if (y < 0)
                        y = 0;
                    if (y > 100)
                        y = 100;
                    dataLive.push(y);
                }

                var res = [];
                for (var i = 0; i < dataLive.length; ++i)
                    res.push([i, dataLive[i]]);

                // Show live chart info
                $('#dash-chart-live-info').html(y.toFixed(0) + '%');

                return res;
            }

            // Update live chart
            function updateChartLive() {
                chartLive.setData([getRandomData()]);
                chartLive.draw();
                setTimeout(updateChartLive, 60);
            }

            // Initialize live chart
            var chartLive = $.plot(chartLive,
                [{data: getRandomData()}],
            {
                series: {shadowSize: 0},
                lines: {show: true, lineWidth: 1, fill: true, fillColor: {colors: [{opacity: 0.2}, {opacity: 0.2}]}},
                colors: ['#34495e'],
                grid: {borderWidth: 0, color: '#aaaaaa'},
                yaxis: {show: true, min: 0, max: 110},
                xaxis: {show: false}
            }
            );

            // Start getting new data
            updateChartLive();
        }
    };
}();