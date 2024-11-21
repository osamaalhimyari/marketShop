<!-- resources/views/components/form-select.blade.php -->
<div class="form-group mb-4">
    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
  
   <select name="{{ $name }}" 
   class="border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 rounded-lg p-2 w-full appearance-none 
       text-left rtl:text-right pr-8 rtl:pl-8 " 
       @if (($disabled??false))
           disabled
       @endif
   required>
   @foreach ($options as $option)
       <option value="{{ $option['id'] }}" {{ $option['id'] == $selected ? 'selected' : '' }}>
           {{ $option['name'] }}
       </option>
   @endforeach
</select>

</div>
