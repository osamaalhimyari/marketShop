

<x-layouts.app :pageTitle="__('dashboard')">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        

        <!-- Display Success or Error Messages -->
       
        <x-alert  class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 flex" />
        <!-- Search Form -->
        <div class="flex items-center mb-8">
          
          
            <a href={{route('admin-show-Product', 'Pid='. null)}} class="flex-shrink-0 mr-4">
                <button class="btn bg-gray-900 rounded-[5px]  p-2 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white" >
                  <span class=" font-bold">{{__('AddNewProduct')}}</span>
                </button>
                
              </a>
            <form action="{{ url('/search-product') }}" method="GET" class="flex flex-grow justify-center">
                @csrf
                <input type="text" name="search" placeholder="Search products"
                    class="w-full sm:w-1/2 px-4 py-2 rounded border border-gray-300 dark:border-gray-600 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-400 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                />
            </form>
        </div>
        
        
        <!-- Products Table -->
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{__('AllProductsCount')."  " ."($countProducts)"}} </h2>
            </div>
            
            <div class="overflow-x-auto">
                         
                <table class="min-w-full bg-white dark:bg-gray-800 text-left text-gray-600 dark:text-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-2 font-medium text-gray-900 dark:text-gray-100">{{ __('ID') }}</th>
                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ __('image') }}</th>
                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ __('name') }}</th>
                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ __('category') }}</th>
                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ __('price') }}</th>
                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ __('currency') }}</th>
                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ __('discount') }}</th>
                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ __('quantity') }}</th>
                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ __('delete') }}</th>
                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ __('Edit') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr id="product-{{$product->id}}" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-6 py-2 text-gray-900 dark:text-gray-100">{{ $product->id }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{  url('storage') . '?img=' .( $product->product_images->first()->imagePath??'') }}" alt="Product Image"
                                        class="w-16 h-16 object-cover rounded" />
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->title }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->category->name }}</td>
                                <td class="px-6 py-4 text-orange-500 dark:text-orange-400"><span class="text-gray-900 dark:text-white font-medium text-sm md:text-sm">{{ $globalConfig->currency->sign }}</span> {{ $product->price }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100"> {{ $globalConfig->currency->name }}</td>
                                <td class="px-6 py-4 text-green-500 dark:text-green-400">{{ $product->discount }}%</td>
                                <td class="px-6 py-4 text-red-500 dark:text-red-400">{{ $product->quantity }}</td>
                                <td class="px-6 py-4">
                                    <x-dialogs.alert-button 
                                    :class="'px-4 py-2 text-red-600 dark:text-red-400 border border-red-600 dark:border-red-400 rounded hover:bg-red-600 hover:text-white transition duration-200'"
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
                                </td>
                                
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin-show-Product', 'Pid=' . $product->id) }}" aria-label="{{ __('Edit') }}">
                                        <button class="px-4 py-2 text-blue-600 dark:text-blue-400 border border-blue-600 dark:border-blue-400 rounded hover:bg-blue-600 hover:text-white transition duration-200">
                                            {{ __('Edit') }}
                                        </button>
                                    </a>
                                </td>
                                
                                
                            </tr>

                           
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8">
                                    <div class="flex flex-col items-center">
                                        
                                        <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-300">No Product Was Found!</h4>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                       
                    </tbody>
                </table>
               
            </div> 
              <!-- Use the confirmation dialog component and pass JavaScript as a string in the onConfirm prop -->
                        
            <div class="mt-8">
                    {{ $products->links() }}
                </div>
        </div>
    </div>


   
</x-layouts.app>
