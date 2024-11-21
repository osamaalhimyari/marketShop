<div class="form-group mb-4">
    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
    <input value="{{ $value }}" name="{{ $name }}" type="{{ $type?? 'text' }}" 
        class="border border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full bg-white dark:bg-gray-700 dark:text-gray-100" 
        required />
</div>
