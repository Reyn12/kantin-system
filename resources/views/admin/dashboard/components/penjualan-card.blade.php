{{-- Grafik Penjualan --}}
<div class="relative">
    {{-- Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/30 via-purple-500/30 to-pink-500/30 rounded-xl blur-xl"></div>
    
    {{-- Content --}}
    <div class="relative bg-white/80 backdrop-blur-sm rounded-xl p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-0 mb-6">
            <div>
                <h2 class="text-xl font-bold">Grafik Penjualan</h2>
                <p class="text-gray-500 text-sm">7 hari terakhir</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-green-500">+6.4%</span>
                <select class="px-3 py-1.5 bg-gray-100 rounded-lg text-sm" id="filterPeriode">
                    <option value="7">7 Hari</option>
                    <option value="30">30 Hari</option>
                    <option value="90">90 Hari</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-6 md:gap-4">
            <div class="flex flex-col">
                <span class="text-3xl font-bold text-indigo-600">Rp956.000</span>
                <span class="text-sm text-gray-500">vs 7 hari sebelumnya</span>
            </div>
            <div class="flex-1">
                <div id="penjualanChart" class="h-64"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Data dummy untuk grafik
    var options = {
        series: [{
            name: 'Penjualan',
            data: [30000, 45000, 35000, 60000, 40000, 50000, 45000]
        }],
        chart: {
            type: 'bar',
            height: 250,
            toolbar: {
                show: false
            }
        },
        colors: ['#6366f1'], // Warna indigo yang sama dengan tema
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '60%',
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            labels: {
                style: {
                    colors: '#9ca3af' // text-gray-400
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return 'Rp' + (value/1000) + 'k'
                },
                style: {
                    colors: '#9ca3af' // text-gray-400
                }
            }
        },
        grid: {
            borderColor: '#e5e7eb', // border-gray-200
            strokeDashArray: 4
        },
        fill: {
            opacity: 1
        }
    };

    var chart = new ApexCharts(document.querySelector("#penjualanChart"), options);
    chart.render();

    // Event listener untuk filter periode
    document.getElementById('filterPeriode').addEventListener('change', function(e) {
        // Di sini nanti bisa ditambah logic untuk update data berdasarkan periode
        console.log('Period changed to:', e.target.value);
    });
</script>
