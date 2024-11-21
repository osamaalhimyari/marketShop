@props(['orderData'])

<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
    <h4 class="text-[3vw] sm:text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">{{ __('SalesOverview') }}</h4>
    <div class="relative h-64">
        <canvas id="salesChart" class="absolute inset-0 w-full h-full"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js library is not loaded.');
                return;
            }

            // Prepare Order Data from `orderData`
            const orderData = @json($orderData);

            // Define labels and data for each status, using translation functions
            const statusLabels = [
                "{{ __('Pending') }}",
                "{{ __('Accepted') }}",
                "{{ __('Passed') }}",
                "{{ __('Rejected') }}"
            ];
            const salesData = [
                orderData[0]?.count || 0, // Status 0: Pending
                orderData[1]?.count || 0, // Status 1: Accepted
                orderData[2]?.count || 0, // Status 2: Passed
                orderData[3]?.count || 0  // Status 3: Rejected
            ];

            // Chart.js Data Setup
            const salesChartData = {
                labels: statusLabels,
                datasets: [{
                    label: "{{ __('TotalOrders') }}",
                    data: salesData,
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)',  // Pending
                        'rgba(75, 192, 192, 0.2)',  // Accepted
                        'rgba(54, 162, 235, 0.2)',  // Passed
                        'rgba(255, 99, 132, 0.2)'   // Rejected
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            // Chart Configuration
            const salesChartConfig = {
                type: 'bar',
                data: salesChartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: { size: 16 }, // Larger font size for ticks
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#E5E7EB' : '#4B5563'
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 16 },
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#E5E7EB' : '#4B5563'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: { size: '1.5vw' }, // Responsive font for legend labels
                                color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#E5E7EB' : '#4B5563'
                            }
                        }
                    }
                }
            };

            // Render the Chart
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, salesChartConfig);
        });
    </script>
</div> 
