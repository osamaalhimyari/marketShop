<div x-data="searchModal()" class="relative">
    <!-- Button -->
    <button
        class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 lg:hover:bg-gray-200 dark:hover:bg-gray-700/50 dark:lg:hover:bg-gray-800 rounded-full"
        @click="openModal()"
        aria-controls="search-modal"
    >
        <span class="sr-only">Search</span>
        <svg class="fill-current text-gray-500/80 dark:text-gray-400/80" width="30px" height="30px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7ZM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5Z" />
            <path d="m13.314 11.9 2.393 2.393a.999.999 0 1 1-1.414 1.414L11.9 13.314a8.019 8.019 0 0 0 1.414-1.414Z" />
        </svg>
    </button>

    <!-- Modal -->
    <div
        class="fixed inset-0 bg-gray-900 bg-opacity-30 z-50 transition-opacity"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        aria-hidden="true"
        @click="closeModal"
        x-cloak
    ></div>

    <div
        id="search-modal"
        class="fixed inset-0 z-50 overflow-hidden flex items-start top-20 mb-4 justify-center px-4 sm:px-6"
        x-show="open"
        x-transition:enter="transition ease-in-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in-out duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        x-cloak
    >
        <div
            class="bg-white dark:bg-gray-800 border border-transparent dark:border-gray-700/60 overflow-auto max-w-2xl w-full max-h-full rounded-lg shadow-lg"
            @click.stop
        >
            <!-- Search Form -->
            <form 
            method="GET" 
            action="{{ $rute ?? '' }}" 
            class="border-b border-gray-200 dark:border-gray-700/60" 
            @submit.prevent="saveSearch(); $el.submit()">
            <div class="relative">
                <label for="modal-search" class="sr-only">{{ __('Search') }}</label>
                <input
                    id="modal-search"
                    name="text"
                    class="w-full dark:text-gray-300 bg-white dark:bg-gray-800 border-0 focus:ring-transparent placeholder-gray-400 dark:placeholder-gray-500 appearance-none py-3 pl-10 pr-4"
                    type="search"
                    placeholder="Search Anything…"
                    x-model="query"
                    x-ref="searchInput"
                />
                <button
                    class="absolute inset-0 right-auto group"
                    type="submit"
                    aria-label="Search"
                >
                    <svg
                        class="shrink-0 fill-current text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 ml-4 mr-2"
                        width="16"
                        height="16"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7ZM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5Z"
                        />
                        <path
                            d="m13.314 11.9 2.393 2.393a.999.999 0 1 1-1.414 1.414L11.9 13.314a8.019 8.019 0 0 0 1.414-1.414Z"
                        />
                    </svg>
                </button>
            </div>
        </form>
        
            <!-- Recent Searches -->
            <div class="py-4 px-2">
                <div class="mb-3 last:mb-0">
                    <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase px-2 mb-2">
                        Recent searches
                    </div>
                    <ul class="text-sm">
                        <template x-for="(term, index) in history" :key="term">
                            <li
                                class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/20 cursor-pointer"
                                @click="selectHistoryItem(term)"
                            >
                                <div class="flex items-center">
                                    <span
                                        x-text="term"
                                        class="text-gray-800 dark:text-gray-100"
                                    ></span>
                                </div>
                                <button
                                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
                                    @click.stop="removeHistoryItem(index)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   function searchModal() {
    return {
        open: false,
        query: '',
        history: JSON.parse(localStorage.getItem('searchHistory')) || [],
        openModal() {
            this.open = true;
            this.$nextTick(() => this.$refs.searchInput.focus());
        },
        closeModal() {
            this.open = false;
        },
        removeHistoryItem(index) {
            this.history.splice(index, 1);
            localStorage.setItem('searchHistory', JSON.stringify(this.history));
        },
        selectHistoryItem(term) {
            this.query = term;
            this.$refs.searchInput.focus();
        },
        saveSearch() {
            if (this.query.trim() && !this.history.includes(this.query.trim())) {
                this.history.unshift(this.query.trim());
                if (this.history.length > 10) {
                    // Limit the history to the 10 most recent searches
                    this.history.pop();
                }
                localStorage.setItem('searchHistory', JSON.stringify(this.history));
            }
        }
    };
}

</script>
