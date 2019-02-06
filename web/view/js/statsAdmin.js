/*Obtiene los datos de la BBDD y llama a la libreria Chart.js para crear las estadisticas*/
$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: "./index.php?controller=admin&action=getStats&c=true"
    }).done(function (data) {
        data = JSON.parse(data);
        var ctx = document.getElementById("stats");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data["x"],
                datasets: [{
                    label: 'Veces Pedido',
                    data: data["y"],
                    borderWidth: 1,
                    backgroundColor: 'rgba(130, 0, 95, 0.65)',
                    borderColor: 'rgba(130, 0, 95, 1)'
                }]
            },
            options: {
                scaleShowValues: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            autoSkip: false
                        }
                    }]
                }
            }
        });
    });
});