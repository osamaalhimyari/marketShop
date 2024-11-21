

<div class="flex  bg-white dark:bg-gray-800 rounded ">
    <x-dialogs.alert-button 
    :class="'px-4 py-2 ml-2 mr-2 text-red-600 dark:text-red-400 border border-red-600 dark:border-red-400 rounded hover:bg-red-600 hover:text-white transition duration-200'"
    :title="__('alert')"
    :message="__('itmDeleteMessage')"
    :buttonTxt="__('delete')"
    :rute="route('admin-delete-Product', ['Pid' => $product->id])"
    :confirmtxt="__('delete')"
    :canceltxt="__('cancel')" 
    :id="'modal-' . $product->id"
    >
    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
    </svg>

    </div>
</x-dialogs.alert-button >
<!--    edit-->
<a href="{{ route('admin-show-Product', 'Pid=' . $product->id) }}" aria-label="{{ __('Edit') }}">
    <button class="px-4 py-2 ml-2 mr-2 text-blue-600 dark:text-blue-400 border border-blue-600 dark:border-blue-400 rounded hover:bg-blue-600 hover:text-white transition duration-200">
        {{ __('Edit') }}
    </button>
</a>

</div>