<!-- resources/views/components/form-checkbox.blade.php -->

<div class="form-group mb-4 m-auto items-center justify-center">
    <label class="flex items-center mb-2 gap-6 text-xl font-medium text-gray-700 dark:text-gray-300">
        <input type="checkbox" name="{{ $name }}" value="1" 
            {{ $checked ?? true ? 'checked' : '' }} 
            class="border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 rounded mr-2"
            style="width: 15px; height: 15px; transform: scale(1.5); margin-right: 10px;" />
        <span>{{ $label }}</span>
    </label>
</div>
