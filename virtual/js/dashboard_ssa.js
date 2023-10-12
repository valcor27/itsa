/*
const ctx = document.getElementById('bar_documentos');

 new Chart(ctx, {
 type: 'bar',
 data: {
     labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
     datasets: [{
     label: '# of Votes',
     data: [12, 19, 3, 5, 2, 3],
     borderWidth: 1
     }]
 },
 options: {
     scales: {
     y: {
         beginAtZero: true
     }
     }
 }
 });
*/
$(document).ready(function() {
    // Este código se ejecutará después de que el DOM esté listo

    var ctx = document.getElementById("bar_documentos").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: "# of Votes",
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                    "rgba(255, 159, 64, 0.2)"
                ],
                borderColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)"
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Selecciona el elemento canvas por su ID
    var ctx = document.getElementById("donut_documentos").getContext("2d");

    // Datos para la gráfica de dona
    var data = {
        labels: ["Rojo", "Azul", "Amarillo", "Verde", "Morado"],
        datasets: [{
            data: [12, 19, 3, 5, 2],
            backgroundColor: ["#FF5733", "#3498DB", "#F39C12", "#2ECC71", "#9B59B6"]
        }]
    };

    // Configuración de la gráfica de dona
    var options = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            display: true,
            position: "right"
        },
        title: {
            display: true,
            text: "Gráfica de Dona"
        }
    };

    // Crear la gráfica de dona
    var donut_documentos = new Chart(ctx, {
        type: "doughnut",
        data: data,
        options: options
    });
});
