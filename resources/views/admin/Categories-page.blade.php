


<x-layouts.app :pageTitle="__('categoriesPage')">
    <div class="container mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left side: Form for adding or editing categories -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                <h4 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">
                    {{ isset($editCategory) ? __('updateCategory') : __('AddNewCategory')}}
                </h4>
                <form action="{{ isset($editCategory) ? route('categories.update', $editCategory->id) : route('categories.store') }}" method="POST" class="space-y-5">
                    @csrf
                    @if(isset($editCategory))
                        @method('PUT')
                    @endif
            
                   
                    <div>
                        <label for="name" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('categoryName') }}</label>
                        <input type="text" name="name" id="name" value="{{ isset($editCategory) ? $editCategory->name : old('name') }}" required 
                            class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 text-lg text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 shadow-sm">
                    </div>
                    
                    <div class="flex space-x-3 mt-4">
                        <button type="submit" 
                            class="ml-2 mr-2 px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition">
                            {{ isset($editCategory) ? __('saveChanges') : __('AddNewCategory') }} 
                        </button>
                        @if(isset($editCategory))
                            <a href="{{ route('categories.index') }}" 
                                class="px-5 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 transition ">
                                {{__('cancel')}}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            
            <!-- Right side: List of categories -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
                <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{__('categoryList')}}</h4>
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300 font-medium">{{__('ID')}}</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300 font-medium">{{__('name')}}</th>
                                <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300 font-medium">{{__('Actions')}}</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($categories as $category)
                                <tr onclick="window.location='{{ route('categories.index', ['edit' => $category->id]) }}'" 
                                    class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 {{ isset($editCategory) && $editCategory->id === $category->id ? 'bg-blue-100 dark:bg-blue-900' : '' }}">
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $category->id }}</td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $category->name }}</td>
                                    <td class="px-4 py-2">
                                        

                                        <x-dialogs.alert-button 
                                        :class="'px-4 py-2 text-red-600 dark:text-red-400 border border-red-600 dark:border-red-400 rounded hover:bg-red-600 hover:text-white transition duration-200'"
                                        :title="__('alert')"
                                        :message="__('itmDeleteMessage')"
                                        :buttonTxt="__('delete')"
                                        :rute="route('categories.destroy', $category->id)"
                                        :confirmtxt="__('delete')"
                                        :canceltxt="__('cancel')" 
                                        :id="'modal-' . $category->id"
                                        >
                                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                   
                                        </div>
                                    </x-dialogs.alert-button >
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
