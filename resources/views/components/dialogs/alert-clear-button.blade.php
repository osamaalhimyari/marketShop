@props([
    'buttonTxt' => '...',
    'title' => 'alert',
    'message' => 'message',
    'confirmtxt' => 'confirm',
    'canceltxt' => 'cancel',
    'id' => 'modal-' . uniqid(), // Generate a unique ID for each modal instance
])

<!-- Button to open the modal -->
<button type="button" onclick="event.stopPropagation(); toggleModal('show-{{ $id }}', true)"
    class="default-class {{ $attributes->get('class') }}">
    {{ $buttonTxt }}
</button>

<!-- Modal -->
<div id="show-{{ $id }}"
    class="fixed inset-0 hidden flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
    <!-- Modal content -->

        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <div class="flex items-start justify-center">
                {{ $slot }}
                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900">{{ $title }}</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">{{ $message }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                {{-- <form id="{{ $id }}"  name="{{ $id }}" method="POST" action="{{ $rute }}"> --}}
                    {{-- @csrf --}}
                    {{-- @method('DELETE') --}}
                <button id="{{ $id }}"
                    onclick="event.stopPropagation(); toggleModal('show-{{ $id }}', false)"
                    
                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 transition sm:ml-3 sm:w-auto">
                    {{ $confirmtxt }}
                </button>
                <button 
                    onclick="event.stopPropagation(); toggleModal('show-{{ $id }}', false)"
                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition sm:mt-0 sm:w-auto">
                    {{ $canceltxt }}
                </button>
            {{-- </form> --}}
            </div>
</div>
</div>

<script>
    function toggleModal(id, show) {
        const modal = document.getElementById(id);
        if (show) {
            
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
</script>
