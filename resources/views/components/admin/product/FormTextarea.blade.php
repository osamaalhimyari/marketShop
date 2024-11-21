<!-- resources/views/components/form-textarea.blade.php -->
<div class="form-group mb-4">
    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
    <textarea name="{{ $name }}" class="border border-gray-300 dark:border-gray-600 rounded-lg p-5 w-full bg-white dark:bg-gray-700 dark:text-gray-100"
        required rows="1" style="height: auto; overflow-y: hidden;" 
        oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';">{{ $value }}</textarea>
</div>