import Chart from 'chart.js/auto';

export function initChart() {
    if (!window.kunjunganData) return;

    const data = window.kunjunganData;

    const labels = data.map(item => item.bulan);
    const totals = data.map(item => item.total);

    const ctx = document.getElementById('chartKunjungan');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: totals,
            }]
        }
    });

    const trendCanvas = document.getElementById('trendChart');

    if (trendCanvas) {
        new Chart(trendCanvas, {
            type: 'line',
            data: {
                labels: ['SOP RS', 'Promkes', 'Lansia', 'Gizi'],
                datasets: [{
                    label: 'Jumlah Dibaca',
                    data: [5, 8, 12, 6],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
}