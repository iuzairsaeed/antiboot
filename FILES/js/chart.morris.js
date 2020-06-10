$(function(){

  'use strict';
  new Morris.Line({

    element: 'morrisLine1',

    data: [

      { y: '2006', a: 20, b: 10 },

      { y: '2007', a: 30,  b: 15 },

      { y: '2008', a: 60,  b: 40 },

      { y: '2009', a: 40,  b: 25 },

      { y: '2010', a: 30,  b: 15 },

      { y: '2011', a: 45,  b: 20 },

      { y: '2012', a: 60, b: 40 }

    ],

    xkey: 'y',

    ykeys: ['a', 'b'],

    labels: ['Series A', 'Series B'],

    lineColors: ['#7CBDDF','#5B93D3'],

    lineWidth: 1,

    ymax: 'auto 100',

    gridTextSize: 11,

    hideHover: 'auto',

    smooth: false,

    resize: true

  });

});

