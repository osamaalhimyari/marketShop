@php
    $orderStatuses = [
        'pending' => __('Pending'),
        'accepted' => __('Accepted'),
        'passed' => __('Passed'),
        'rejected' => __('Rejected'),
        'all' => __('All'),
    ];

    $ordersByStatus = [
        'pending' => $orders->where('status', '0' || null),
        'accepted' => $orders->where('status', '1'),
        'rejected' => $orders->where('status', '2'),
        'passed' => $orders->where('status', '3'),
        'all' => $orders,
    ];
@endphp

<!-- Main Container -->
<div class="bg-white shadow-md rounded-lg p-6 mt-6 dark:bg-gray-800">
    <h4 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">{{ __('IncomingOrders') }}</h4>

    @if($orders->isEmpty())
        <div class="p-6 mt-4 border border-gray-300 bg-gray-100 rounded-lg text-gray-500 dark:text-gray-300 text-lg text-center">
            {{ __('noData') }}
        </div>
    @else
        <!-- Tab Navigation -->
        <div class="mb-4">
            <ul class="flex flex-wrap">
                @foreach($orderStatuses as $statusKey => $statusLabel)
                    <li class="mr-1 mb-2">
                        <a href="javascript:void(0);" 
                           class="tab-link py-3 px-5 font-semibold text-lg rounded-t-lg transition-colors duration-300 text-gray-600 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700 {{ $loop->first ? 'active-tab' : '' }}" 
                           onclick="showTab('{{ $statusKey }}')">
                            {{ $statusLabel }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Tab Content with Scoped Classes -->
        <div class="overflow-x-auto border border-gray-300 rounded-lg p-4">
            @foreach($ordersByStatus as $statusKey => $ordersForStatus)
                <div id="{{ $statusKey }}" class="tab-content {{ $loop->first ? 'visible-content' : 'invisible-content' }}">
                    @if($ordersForStatus->isEmpty())
                        <div class="p-6 text-center text-gray-500 dark:text-gray-300 text-lg">
                            {{ __('noData') }}
                        </div>
                    @else
                        <x-admin.dashboard.orders-table :orders="$ordersForStatus"/>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    function showTab(status) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.replace('visible-content', 'invisible-content');
        });

        // Remove active styling from all tab links
        document.querySelectorAll('.tab-link').forEach(link => {
            link.classList.remove('active-tab', 'font-bold');
        });

        // Show selected tab and add active styling
        document.getElementById(status).classList.replace('invisible-content', 'visible-content');
        document.querySelector(`.tab-link[onclick="showTab('${status}')"]`).classList.add('active-tab', 'font-bold');
    }
</script>

<style>
    /* Active tab styling */
    .active-tab {
        background-color: #e2e8f0; /* Darker background in light mode */
        color: #1A202C; /* Dark gray text */
    }

    .dark .active-tab {
        background-color: #4A5568; /* Lighter background in dark mode */
        color: #EDF2F7; /* Light gray text */
    }

    /* Scoped Content Visibility Classes */
    .visible-content { display: block; }
    .invisible-content { display: none; }

    /* Responsive styling */
    @media (max-width: 768px) {
        .tab-link {
            text-lg;
            padding: 0.75rem 1.5rem;
        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .text-lg {
            font-size: 1.125rem;
        }
    }
</style>
