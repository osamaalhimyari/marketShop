<div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 sm:p-8 transition-all duration-300 ">
    <!-- Header -->
    <h4 class="text-2xl sm:text-3xl font-semibold text-gray-800 dark:text-gray-200 mb-6 text-center">
        {{ __('ProductsPerCategory') }}
    </h4>

    <!-- Chart Container -->
    <div class="relative h-64 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 ">
        <canvas id="productsPerCategoryChart" class="absolute inset-0 w-full h-full"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryNames = @json($categories->pluck('name')); // Get category names
            const productCounts = @json($categories->map(function($category) {
                return $category->products->count(); // Get product counts for each category
            }));

            // Dynamically fetch theme colors
            const getThemeColors = () => {
                const isDarkMode = document.documentElement.classList.contains('dark');
                return {
                    textColor: isDarkMode ? '#E5E7EB' : '#1F2937', // Adaptive text color
                    gridLineColor: isDarkMode ? 'rgba(229, 231, 235, 0.1)' : 'rgba(31, 41, 55, 0.1)', // Subtle grid lines
                    tooltipBackgroundColor: isDarkMode ? 'rgba(31, 41, 55, 0.9)' : 'rgba(255, 255, 255, 0.9)' // Higher contrast tooltip background
                };
            };

            const { textColor, gridLineColor, tooltipBackgroundColor } = getThemeColors();

            const productsPerCategoryData = {
                labels: categoryNames,
                datasets: [{
                    label: "{{__('TotalProducts')}}",
                    data: productCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(255, 255, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(255, 255, 255, 1)',
                    ],
                    borderWidth: 1,
                }],
            };

            const productsPerCategoryConfig = {
                type: 'doughnut',
                data: productsPerCategoryData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 16,
                                },
                                color: textColor, // Adaptive legend text color
                                padding: 15,
                            },
                        },
                        tooltip: {
                            bodyColor: textColor, // Adaptive tooltip text color
                            titleColor: textColor,
                            backgroundColor: tooltipBackgroundColor, // Improved contrast for tooltip background
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                color: gridLineColor, // Subtle grid lines
                            },
                            ticks: {
                                color: textColor, // Adaptive tick text color
                                font: {
                                    size: 14,
                                },
                            },
                        },
                        y: {
                            grid: {
                                color: gridLineColor, // Subtle grid lines
                            },
                            ticks: {
                                color: textColor, // Adaptive tick text color
                                font: {
                                    size: 14,
                                },
                            },
                        },
                    },
                },
            };

            const chartElement = document.getElementById('productsPerCategoryChart');
            const productsPerCategoryChart = new Chart(chartElement, productsPerCategoryConfig);

            // Listen for theme change and dynamically update chart colors
            const observer = new MutationObserver(() => {
                const { textColor: newTextColor, gridLineColor: newGridLineColor, tooltipBackgroundColor: newTooltipBackgroundColor } = getThemeColors();

                // Update dynamic colors for legend, tooltip, and grid lines
                productsPerCategoryChart.options.plugins.legend.labels.color = newTextColor;
                productsPerCategoryChart.options.plugins.tooltip.bodyColor = newTextColor;
                productsPerCategoryChart.options.plugins.tooltip.titleColor = newTextColor;
                productsPerCategoryChart.options.plugins.tooltip.backgroundColor = newTooltipBackgroundColor;
                productsPerCategoryChart.options.scales.x.ticks.color = newTextColor;
                productsPerCategoryChart.options.scales.x.grid.color = newGridLineColor;
                productsPerCategoryChart.options.scales.y.ticks.color = newTextColor;
                productsPerCategoryChart.options.scales.y.grid.color = newGridLineColor;

                productsPerCategoryChart.update();
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class'], // Watch for changes in the 'class' attribute
            });
        });
    </script>
</div>
