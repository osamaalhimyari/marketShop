<div class="form-group mb-4">
    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
    <input 
        value="{{ $value }}" 
        name="{{ $name }}" 
        type="{{ $type ?? 'text' }}" 
        @if(isset($maxlength)) maxlength="{{ $maxlength }}" @endif
        @if(isset($minlength)) minlength="{{ $minlength }}" @endif
        oninput="this.value = this.value.replace(/[^0-9]/g, ''); 
                  @if(isset($maxlength)) this.value = this.value.slice(0, {{ $maxlength }}); @endif"
        class="border border-gray-300 dark:border-gray-600 rounded-lg p-2 w-full bg-white dark:bg-gray-700 dark:text-gray-100" 
        required />
</div>
