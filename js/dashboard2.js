/* globals Chart:false */

(() => {
  'use strict'

  // Graphs
  const ctx = document.getElementById('myChart')
  // eslint-disable-next-line no-unused-vars
  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [ 
        'NOVEMBRO22',  
        'FEVEREIRO23', 
        'MAIO23',
        'AGOSTO23',
        'NOVEMBRO23',
        'FEVEREIRO24',
        'MAIO24',
        
      ],
      datasets: [{
         data: [ 
  10.551828,
  8.048692,                  
  9.549064,
  7.944680, 
  9.922003,  
  8.686060,
  10.910794
        ],

        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        borderWidth: 100,
        pointBackgroundColor: '#007bff'
        
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          boxPadding: 3
        }
      }
    }
  })
})()
