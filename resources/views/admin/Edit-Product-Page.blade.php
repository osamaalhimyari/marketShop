 <x-layouts.app :pageTitle="__('EditProduct')">
     
     <x-alert class="mb-4 max-w-lg" />
     <div class="container mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">

         <h4 class="text-xl font-bold mb-4 dark:text-white">{{ __('EditProduct') }}</h4>

         <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
             <div class="md:col-span-2">
                 <form id="updateForm" name="updateForm"    action="{{ route('admin-update-Products',[ 'Pid'=> sha1($product->id)]) }}" method="POST" 
                
                     enctype="multipart/form-data"  >
                     @csrf

                     <x-admin.product.FormInput label="{{ __('name') }}" name="title" type="text"
                         :value="$product->title" />
                     <x-admin.product.FormInput label="{{ __('headLine') }}" name="headline" type="text"
                         :value="$product->headLine" />
                     <x-admin.product.FormTextarea label="{{ __('description') }}" name="description"
                         :value="$product->description" />

                     <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                         <x-admin.product.FormNumberInput label="{{ __('quantity') }}" name="quantity" type="number"
                             :value="$product->quantity" minlength="1" />
                         <x-admin.product.FormNumberInput label="{{ __('discount') }} %" name="discount" type="number"
                             :value="$product->discount" maxlength="2" minlength="1" />
                         <x-admin.product.FormNumberInput label="{{ __('price') }}" name="price" type="number"
                             :value="$product->price" minlength="0" />
                     </div>

                     <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
                         <x-admin.product.FormSelect label="{{ __('category') }}" name="category_id" :options="$categories"
                             :selected="$product->category_id" />
                         <x-admin.product.FormSelect label="{{ __('currency') }}" name="currency_id" :options="$currencies"
                             :selected="$product->currency_id" :disabled="true" />
                     </div>
                     <x-admin.product.FormCheckbox label="{{ __('published') }}" name="published" :checked="$product->published" />
                         
                         
                         <x-admin.product.ImageUpload :product="$product" />
                         
                         
                         <button form="updateForm" type="submit"
                         class="mt-6 bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 dark:hover:bg-blue-800 transition">{{ __('saveChanges') }}</button>
                        </form>
                    </div>
                    <x-admin.product.ImagesShow :product="$product" />
            </div>
     </div>
 </x-layouts.app>
