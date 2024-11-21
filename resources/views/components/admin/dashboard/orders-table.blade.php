
<!-- orders_table.blade.php -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead>
            <tr>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">{{ __('ID') }}</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">{{ __('CustomerName') }}</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">{{ __('CustomerAddress') }}</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">{{ __('OrderTotalPrice') }}</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">{{ __('Status') }}</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">{{ __('CreatedAt') }}</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-700 dark:divide-gray-600">
            @foreach($orders as $order)
                <tr onclick="toggleRow({{ $order->id }})" class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" id="main-row-{{ $order->id }}">
                    <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $order->id }}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $order->name }}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $order->address }}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-left dark:text-gray-300">{{ $globalConfig->currency->sign }}  {{ number_format($order->total_price, 2) }}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ ucfirst($order->status) }}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                <tr id="row-{{ $order->id }}" class="hidden bg-gray-100 dark:bg-gray-800 border-b border-gray-300 dark:border-gray-600">
                    <td colspan="6" class="px-4 py-4">
                        <a href="{{ route('orders.index', ['orderid' => $order->id]) }}"><button type="submit" class="bg-green-500 text-white rounded px-4 py-2 mx-1 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">{{ __('show') }}</button></a>
                        <div class="flex justify-center">
                            
                            <form action="{{ route('orders.status', ['orderid' => $order->id, 'status' => 1]) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white rounded px-4 py-2 mx-1 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">{{ __('Accepted') }}</button>
                            </form>
                            <form action="{{ route('orders.status', ['orderid' => $order->id, 'status' => 2]) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white rounded px-4 py-2 mx-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">{{ __('Rejected') }}</button>
                            </form>
                            <form action="{{ route('orders.status', ['orderid' => $order->id, 'status' => 3]) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 mx-1 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ __('Passed') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    let expandedRowId = null;

    function toggleRow(orderId) {
        if (expandedRowId && expandedRowId !== orderId) {
            document.getElementById(`row-${expandedRowId}`).classList.add('hidden');
            document.getElementById(`main-row-${expandedRowId}`).classList.remove('bg-gray-100', 'dark:bg-gray-800');
        }

        const selectedRow = document.getElementById(`row-${orderId}`);
        const mainRow = document.getElementById(`main-row-${orderId}`);
        const isExpanded = !selectedRow.classList.contains('hidden');

        if (isExpanded) {
            selectedRow.classList.add('hidden');
            mainRow.classList.remove('bg-gray-100', 'dark:bg-gray-800');
            expandedRowId = null;
        } else {
            selectedRow.classList.remove('hidden');
            mainRow.classList.add('bg-gray-100', 'dark:bg-gray-800');
            expandedRowId = orderId;
        }
    }
</script>
