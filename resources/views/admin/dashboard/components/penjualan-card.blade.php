{{-- Grafik Penjualan --}}
<div class="relative">
    {{-- Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/30 via-purple-500/30 to-pink-500/30 rounded-xl blur-xl"></div>
    
    {{-- Content --}}
    <div class="relative bg-white/80 backdrop-blur-sm rounded-xl p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-0 mb-6">
            <div>
                <h2 class="text-xl font-bold">Grafik Penjualan</h2>
                <p class="text-gray-500 text-sm">{{ $periode }} hari terakhir</p>
            </div>
            <div class="flex items-center gap-2">
                @if($persentasePerubahan > 0)
                    <span class="text-green-500">+{{ $persentasePerubahan }}%</span>
                @elseif($persentasePerubahan < 0)
                    <span class="text-red-500">{{ $persentasePerubahan }}%</span>
                @else
                    <span class="text-gray-500">0%</span>
                @endif
                <select class="px-3 py-1.5 bg-gray-100 rounded-lg text-sm" id="filterPeriode">
                    <option value="7" @if($periode == 7) selected @endif>7 Hari</option>
                    <option value="30" @if($periode == 30) selected @endif>30 Hari</option>
                    <option value="90" @if($periode == 90) selected @endif>90 Hari</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-6 md:gap-4">
            <div class="flex flex-col">
                <span class="text-3xl font-bold text-indigo-600">Rp{{ number_format($totalPenjualanPeriode, 0, ',', '.') }}</span>
                <span class="text-sm text-gray-500">vs {{ $periode }} hari sebelumnya</span>
            </div>
            <div class="flex-1">
                <div id="penjualanChart" class="h-64"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var options = {
        series: [{
            name: 'Penjualan',
            data: @json($data)
        }],
        chart: {
            type: 'bar',
            height: 250,
            toolbar: {
                show: false
            }
        },
        colors: ['#6366f1'],
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
            categories: @json($labels),
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return 'Rp' + value.toLocaleString('id-ID');
                }
            }
        },
        grid: {
            borderColor: '#f3f4f6',
            strokeDashArray: 4
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return 'Rp' + value.toLocaleString('id-ID');
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#penjualanChart"), options);
    chart.render();

    // Event listener untuk filter periode
    document.getElementById('filterPeriode').addEventListener('change', function() {
        window.location.href = '{{ route("admin.dashboard") }}?periode=' + this.value;
    });
</script>