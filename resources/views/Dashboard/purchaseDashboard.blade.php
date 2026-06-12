@extends('Dashboard')
@section('title')
    المشتريات
@endSection

@section('report')
    <livewire:dashboard.purchase-dashboard />
@endSection

@section('script')
    <script>
        let chart;
        let barChart;
        let lineChart;

        function renderChart(labels, values) {
            const ctx = document.getElementById('pieChart');

            // لو في chart قديم احذفيه
            if (chart) chart.destroy();

            // إذا البيانات فاضية اعرض شكل بسيط
            if (!values || values.length === 0) {
                chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['لا يوجد بيانات'],
                        datasets: [{
                            data: [1],
                            backgroundColor: ['#e5e7eb']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'توزيع المشتريات حسب الكمية التابعه للاقسام'
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
                return;
            }

            // الرسم الطبيعي
            chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{

                        data: values,
                        backgroundColor: [
                            '#4ade80',
                            '#60a5fa',
                            '#fbbf24',
                            '#f87171',
                            '#a78bfa',
                            '#34d399'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'توزيع المشتريات حسب الكمية التابعه للاقسام'
                        }
                    }
                }
            });

        }

        // أول تحميل
        document.addEventListener('livewire:init', () => {
            renderChart(
                @json($labels ?? []),
                @json($values ?? [])
            );
        });

        // التحديث مع Livewire
        Livewire.on('updateChart', (event) => {
            renderChart(event[0].labels, event[0].values);
        });


        function renderChartBar(labelsBar, valuesBar) {
            const ctx = document.getElementById('BarChart');

            // لو في chart قديم احذفيه
            if (barChart) barChart.destroy();

            // إذا البيانات فاضية اعرض شكل بسيط
            if (!valuesBar || valuesBar.length === 0) {
                barChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['لا يوجد بيانات'],
                        datasets: [{
                            data: [1],
                            backgroundColor: ['#e5e7eb']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'توزيع المشتريات حسب الاسعار'
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
                return;
            }

            // الرسم الطبيعي
            barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelsBar,
                    datasets: [{
                        label: 'الاسعار',
                        data: valuesBar,
                        backgroundColor: [
                            '#4ade80',
                            '#60a5fa',
                            '#fbbf24',
                            '#f87171',
                            '#a78bfa',
                            '#34d399'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'توزيع المشتريات حسب الاسعار  '
                        }
                    }
                }
            });

        }

        // أول تحميل
        document.addEventListener('livewire:init', () => {
            renderChartBar(
                @json($labelsBar ?? []),
                @json($valuesBar ?? [])
            );
        });

        // التحديث مع Livewire
        Livewire.on('updateChartBar', (event) => {
            renderChartBar(event[0].labelsBar, event[0].valuesBar);
        });

        function renderChartLine(labelsline, valuesline) {
            const ctx = document.getElementById('lineChart');

            // لو في chart قديم احذفيه
            if (lineChart) lineChart.destroy();

            // إذا البيانات فاضية اعرض شكل بسيط
            if (!valuesline || valuesline.length === 0) {
                lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['لا يوجد بيانات'],
                        datasets: [{
                            data: [1],
                            backgroundColor: ['#e5e7eb']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'توزيع المشتريات حسب اليوم والسعر '
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
                return;
            }

            // الرسم الطبيعي
            lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsline,
                    datasets: [{

                        label: 'المشتريات',
                        data: valuesline,
                        borderColor: '#60a5fa',
                        backgroundColor: '#93c5fd',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'توزيع المشتريات حسب اليوم والسعر '
                        }
                    }
                }
            });

        }

        // أول تحميل
        document.addEventListener('livewire:init', () => {
            renderChartLine(
                @json($labelsline ?? []),
                @json($valuesline ?? [])
            );
        });

        // التحديث مع Livewire
        Livewire.on('updateChartLine', (event) => {
            renderChartLine(event[0].labelsline, event[0].valuesline);
        });
    </script>
@endSection
