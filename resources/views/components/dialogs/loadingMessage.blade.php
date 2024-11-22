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
        </div>

        <p id="message" class="text-gray-700">Submitting your order, please wait...</p>
    </div>


</div>