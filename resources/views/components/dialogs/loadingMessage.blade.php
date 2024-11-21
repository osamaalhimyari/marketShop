<style>
    #loadingMessage {
        background-color:unset ; /* Make the background transparent */
        z-index: 50; /* Ensure the modal is above other content */
    }
    .icon {
        width: 40px; /* Set desired width */
        height: 40px; /* Set desired height */
    }
</style>

<div id="loadingMessage" class="fixed inset-0 hidden flex items-center justify-center z-50" style="background-color: rgba(255, 255, 255, 0.363);">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <!-- Loader Spinner -->
        <svg id="loader" class="animate-spin h-8 w-8 text-blue-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>

        <div id="iconContainer" class="hidden">
            <svg id="successIcon"  class="icon hidden   h-8 w-8 text-blue-500 mx-auto mb-4"  xmlns="http://www.w3.org/2000/svg" fill="green" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 13l-1.41 1.41L12 13.83l-3.59 3.59L7 15l5-5 5 5z"/>
            </svg>
            <svg id="errorIcon"  class="icon hidden   h-8 w-8 text-blue-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm0-4h-2V7h2v8z"/>
            </svg>
        </div>

        {{-- <p id="message" class="text-gray-700">Submitting your order, please wait...</p> --}}
    </div>


</div>