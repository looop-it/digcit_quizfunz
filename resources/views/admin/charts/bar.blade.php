<canvas id="myChart" width="400" height="400"></canvas>
<script>

$(function () {
   var ctx = document.getElementById("myChart").getContext('2d');
   var myChart = new Chart(ctx, {
       type: 'bar',
       data: {
           labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
           datasets: [{
               label: '# of Votes',
               data: [12, 19, 3, 5, 2, 3],
               borderWidth: 1
           },{
               label: '# of Votes',
               data: [22, 9, 13, 25, 2, 33],
           }
           ]
       },
       options: {
           scales: {
               yAxes: [{
                   ticks: {
                       beginAtZero:true
                   }
               }]
           }
       }
   }); 
});
</script>