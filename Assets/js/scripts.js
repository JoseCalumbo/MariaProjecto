/**
 * Este arquivo trata da apresentação dos graficos 
 * 
 */

// Graficos de dados consulta diaria
document.addEventListener('DOMContentLoaded', function () {
    // seleciona a tag canvas 
    const ctxConsulta = document.getElementById('myChartcon').getContext('2d');
    // opções e configuração 
    const myChartcon = new Chart(ctxConsulta, {
        type: 'line',
        data: {
            labels: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'],
            datasets: [{
                label: 'Numero total diario de Consulta',
                data: [911, 69, 373, 335, 512, 22, 399],
                backgroundColor: [
                    'rgba(255, 199, 132, 0.2)',
                    'rgba(54, 102, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(0, 0, 222, 0.2)',
                    'rgba(255, 166, 1,0.1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(253, 166, 1, 1)'

                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },

            layout: {
                padding: 0
            }

        }
    });
});


// Graficos de dados consulta 
document.addEventListener('DOMContentLoaded', function () {
    // seleciona a tag canvas 
    const grafConsulta = document.getElementById('graficosConsultas').getContext('2d');

    // Criar o gradiente vertical
    const gradient = grafConsulta.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(19, 82, 175, 0.95)')
    gradient.addColorStop(1, 'rgba(38, 34, 78, 0.84)')

    const data = {
        labels: ['Segunda', 'Treça', 'Quarta', 'Quinta', 'Sexta', 'Sabado', 'Domingo'],
        datasets: [{
            label: 'Visitas',
            data: [950, 390, 100, 260, 80, 340, 270],
            fill: true,
            backgroundColor: gradient,
            borderColor: 'transparent',
            tension: 0.5,
            pointRadius: 0, // ponto invisível normalmente
            pointHoverRadius: 6, // aparece ao passar o mouse
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: '#00ffaa',
            pointHoverBorderWidth: 2
        }]
    };

    const options = {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(18, 41, 240, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                displayColors: false,
                callbacks: {
                    label: function (context) {
                        return `funcionarios: ${context.raw}`;
                    }
                }
            }
        },
        scales: {
            x: { display: false },
            y: { display: false }
        },
        hover: {
            mode: 'nearest',
            intersect: false
        }
    };

    new Chart(grafConsulta, {
        type: 'line',
        data: data,
        options: options
    });

});

// Graficos de dados user 
document.addEventListener('DOMContentLoaded', function () {
    // seleciona a tag canvas 
    const grafUser = document.getElementById('graficosUsuarios').getContext('2d');

    // Criar o gradiente vertical
    const gradient = grafUser.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(17, 165, 153, 0.95)')
    gradient.addColorStop(1, 'rgba(26, 149, 190, 0.7)')

    const data = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Visitas',
            data: [150, 30, 100, 260, 80, 340, 270],
            fill: true,
            backgroundColor: gradient,
            borderColor: 'transparent',
            tension: 0.5,
            pointRadius: 0, // ponto invisível normalmente
            pointHoverRadius: 6, // aparece ao passar o mouse
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: '#00ffaa',
            pointHoverBorderWidth: 2
        }]
    };

    const options = {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(18, 41, 240, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                displayColors: false,
                callbacks: {
                    label: function (context) {
                        return `Valor: ${context.raw}`;
                    }
                }
            }
        },
        scales: {
            x: { display: false },
            y: { display: false }
        },
        hover: {
            mode: 'nearest',
            intersect: false
        }
    };

    new Chart(graficosUsuarios, {
        type: 'line',
        data: data,
        options: options
    });

});

// Graficos de dados user 
document.addEventListener('DOMContentLoaded', function () {
    // seleciona a tag canvas 
    const grafUser1 = document.getElementById('graficosUsuarios1').getContext('2d');

    // Criar o gradiente vertical
    const gradient = grafUser1.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(17, 165, 153, 0.95)')
    gradient.addColorStop(1, 'rgba(26, 149, 190, 0.7)')

    const data = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Visitas',
            data: [200, 300, 400, 460, 600, 340, 270],
            fill: true,
            backgroundColor: gradient,
            borderColor: 'transparent',
            tension: 0.5,
            pointRadius: 0, // ponto invisível normalmente
            pointHoverRadius: 6, // aparece ao passar o mouse
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: '#00ffaa',
            pointHoverBorderWidth: 2
        }]
    };

    const options = {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(18, 41, 240, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                displayColors: false,
                callbacks: {
                    label: function (context) {
                        return `Valor: ${context.raw}`;
                    }
                }
            }
        },
        scales: {
            x: { display: false },
            y: { display: false }
        },
        hover: {
            mode: 'nearest',
            intersect: false
        }
    };

    new Chart(graficosUsuarios1, {
        type: 'line',
        data: data,
        options: options
    });

});

// Graficos de dados user 
document.addEventListener('DOMContentLoaded', function () {
    // seleciona a tag canvas 
    const grafUser2 = document.getElementById('graficosUsuarios2').getContext('2d');

    // Criar o gradiente vertical
    const gradient = grafUser2.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(17, 165, 153, 0.95)')
    gradient.addColorStop(1, 'rgba(26, 149, 190, 0.7)')

    const data = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Visitas',
            data: [50, 300, 700, 260, 80, 340, 70],
            fill: true,
            backgroundColor: gradient,
            borderColor: 'transparent',
            tension: 0.5,
            pointRadius: 0, // ponto invisível normalmente
            pointHoverRadius: 6, // aparece ao passar o mouse
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: '#00ffaa',
            pointHoverBorderWidth: 2
        }]
    };

    const options = {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                enabled: true,
                backgroundColor: 'rgba(18, 41, 240, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                displayColors: false,
                callbacks: {
                    label: function (context) {
                        return `Valor: ${context.raw}`;
                    }
                }
            }
        },
        scales: {
            x: { display: false },
            y: { display: false }
        },
        hover: {
            mode: 'nearest',
            intersect: false
        }
    };

    new Chart(graficosUsuarios2, {
        type: 'line',
        data: data,
        options: options
    });

});