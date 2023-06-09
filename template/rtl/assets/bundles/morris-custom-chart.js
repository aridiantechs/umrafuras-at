"use strict";
setTimeout(function(){
$(document).ready(function() {

    lineChart();
    areaChart();
    donutChart();

    $(window).on('resize',function() {
        window.lineChart.redraw();
        window.areaChart.redraw();
        window.donutChart.redraw();
    });

});

/*Line chart*/
function lineChart() {
    window.lineChart = Morris.Line({
        element: 'line-example',
        data: [
            { y: '2006', a: 100, b: 90 },
            { y: '2007', a: 75, b: 65 },
            { y: '2008', a: 50, b: 40 },
            { y: '2009', a: 75, b: 65 },
            { y: '2010', a: 50, b: 40 },
            { y: '2011', a: 75, b: 65 },
            { y: '2012', a: 100, b: 90 }
        ],
        xkey: 'y',
        redraw: true,
        ykeys: ['a', 'b'],
        hideHover: 'auto',
        labels: ['Series A', 'Series B'],
        lineColors: ['#f75c74', '#f99f4a']
    });
}

/*Area chart*/
function areaChart() {
    window.areaChart = Morris.Area({
        element: 'area-example',
        data: [
            { y: '2006', a: 100, b: 90 },
            { y: '2007', a: 75, b: 65 },
            { y: '2008', a: 50, b: 40 },
            { y: '2009', a: 75, b: 65 },
            { y: '2010', a: 50, b: 40 },
            { y: '2011', a: 75, b: 65 },
            { y: '2012', a: 100, b: 90 }
        ],
        xkey: 'y',
        resize: true,
        redraw: true,
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        lineColors: ['#4fc3f7', '#ff8a65']
    });
}

/*Donut chart*/
function donutChart() {
    window.areaChart = Morris.Donut({
        element: 'donut-example',
        redraw: true,
        data: [
            { label: "", value: 2 },
            { label: "", value: 50 },
            { label: "", value: 20 },
            { label: "", value: 20 },
            { label: "", value: 20 }
        ],
        colors: ['#7cb31a', '#01a1ff', '#fec107', '#d61900', '#ff9801']
    });
}

// Morris bar chart
Morris.Bar({
    element: 'morris-bar-chart',
    data: [{
        y: '2006',
        a: 100,
        b: 90,
        c: 60
    }, {
        y: '2007',
        a: 75,
        b: 65,
        c: 40
    }, {
        y: '2008',
        a: 50,
        b: 40,
        c: 30
    }, {
        y: '2009',
        a: 75,
        b: 65,
        c: 40
    }, {
        y: '2010',
        a: 50,
        b: 40,
        c: 30
    }, {
        y: '2011',
        a: 75,
        b: 65,
        c: 40
    }, {
        y: '2012',
        a: 100,
        b: 90,
        c: 40
    }],
    xkey: 'y',
    ykeys: ['a', 'b', 'c'],
    labels: ['A', 'B', 'C'],
    barColors: ['#4fc3f7','#f0466b', '#33db9e'],
    hideHover: 'auto',
    gridLineColor: '#eef0f2',
    resize: true
});
// Extra chart
Morris.Area({
    element: 'morris-extra-area',
    data: [{
            period: '2010',
            iphone: 0,
            ipad: 0,
            itouch: 0
        }, {
            period: '2011',
            iphone: 50,
            ipad: 15,
            itouch: 5
        }, {
            period: '2012',
            iphone: 20,
            ipad: 50,
            itouch: 65
        }, {
            period: '2013',
            iphone: 60,
            ipad: 12,
            itouch: 7
        }, {
            period: '2014',
            iphone: 30,
            ipad: 20,
            itouch: 120
        }, {
            period: '2015',
            iphone: 25,
            ipad: 80,
            itouch: 40
        }, {
            period: '2016',
            iphone: 10,
            ipad: 10,
            itouch: 10
        }


    ],
    lineColors: ['#ff8a65', '#33db9e', '#4fc3f7'],
    xkey: 'period',
    ykeys: ['iphone', 'ipad', 'itouch'],
    labels: ['Site A', 'Site B', 'Site C'],
    pointSize: 0,
    lineWidth: 0,
    resize: true,
    fillOpacity: 0.8,
    behaveLikeLine: true,
    gridLineColor: '#d2d2d2',
    hideHover: 'auto'

});

/*Site visit Chart*/

Morris.Area({
    element: 'morris-site-visit',
    data: [{
        period: '2010',
        SiteA: 0,
        SiteB: 0,

    }, {
        period: '2011',
        SiteA: 130,
        SiteB: 100,

    }, {
        period: '2012',
        SiteA: 80,
        SiteB: 60,

    }, {
        period: '2013',
        SiteA: 70,
        SiteB: 200,

    }, {
        period: '2014',
        SiteA: 180,
        SiteB: 150,

    }, {
        period: '2015',
        SiteA: 105,
        SiteB: 90,

    }, {
        period: '2016',
        SiteA: 250,
        SiteB: 150,

    }],
    xkey: 'period',
    ykeys: ['SiteA', 'SiteB'],
    labels: ['Site A', 'Site B'],
    pointSize: 0,
    fillOpacity: 0.4,
    pointStrokeColors: ['#b4becb', '#01c0c8'],
    behaveLikeLine: true,
    gridLineColor: '#e0e0e0',
    lineWidth: 0,
    smooth: false,
    hideHover: 'auto',
    lineColors: ['#b4becb', '#01c0c8'],
    resize: true

});
},350);
