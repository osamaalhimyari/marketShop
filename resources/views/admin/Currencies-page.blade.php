<x-layouts.app :pageTitle="__('currenciesPage')">
    {{-- <div class="container mx-auto p-6"> --}}

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
        <!-- Left side: Form for adding or editing currencies -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
            <x-alert class="mb-4 w-full" />
            <h4 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">
                {{ isset($editCurrency) ? __('updateCurrency') : __('AddNewCurrency') }}
            </h4>
            <form
                action="{{ isset($editCurrency) ? route('currencies.update', $editCurrency->id) : route('currencies.store') }}"
                method="POST" class="space-y-5">
                @csrf
                @if (isset($editCurrency))
                    @method('PUT')
                @endif
                <div class="flex">
                    <div class="ml-2 mr-2">
                        <label for="name"
                            class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('currencyName') }}</label>
                        <input type="text" name="name" id="name"
                            value="{{ isset($editCurrency) ? $editCurrency->name : old('name') }}" required
                            class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 text-lg text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 shadow-sm">
                    </div>
                    <div class="ml-2 mr-2">
                        <label for="code"
                            class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('currencyCode') }}</label>
                        <input type="text" name="code" id="code"
                            value="{{ isset($editCurrency) ? $editCurrency->code : old('code') }}" required
                            class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 text-lg text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 shadow-sm">
                    </div>
                    <div class="ml-2 mr-2">
                        <label for="sign"
                            class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('currencySign') }}</label>
                        <input type="text" name="sign" id="sign"
                            value="{{ isset($editCurrency) ? $editCurrency->sign : old('sign') }}" required
                            class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 text-lg text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 shadow-sm">
                    </div>
                </div>

                <div class="flex space-x-3 mt-4">
                    <button type="submit"
                        class="ml-2 mr-2 px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition">
                        {{ isset($editCurrency) ? __('saveChanges') : __('AddNewCurrency') }}
                    </button>
                    @if (isset($editCurrency) && $globalConfig->currency_id != $editCurrency->id)
                        <a href="{{ route('currencies.setDefault', ['edit' => $editCurrency->id]) }}"
                            class="px-5 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition ">
                            {{ __('setDefault') }}
                        </a>
                    @endif
                    @if (isset($editCurrency))
                        <a href="{{ route('currencies.index') }}"
                            class="px-5 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 transition ">
                            {{ __('cancel') }}
                        </a>
                    @endif
                </div>
            </form>

        </div>

        <!-- Right side: List of currencies -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
            <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('currencyList') }}</h4>
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            <div>
                <table
                    class="min-w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg">
                    <thead>
                        <tr>
                            <th
                                class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300 font-medium">
                                {{ __('ID') }}</th>
                            <th
                                class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300 font-medium">
                                {{ __('currencyName') }}</th>
                            <th
                                class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300 font-medium">
                                {{ __('currencyCode') }}</th>
                            <th
                                class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300 font-medium">
                                {{ __('currencySign') }}</th>
                            <th
                                class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300 font-medium">
                                {{ __('Actions') }}</th>
                            <th
                                class="px-2 py-2 border-b border-gray-200 dark:border-gray-700 text-left text-gray-700 dark:text-gray-300 font-medium">
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($currencies as $currency)
                            <tr onclick="window.location='{{ route('currencies.index', ['edit' => $currency->id]) }}'"
                                class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 {{ isset($editCurrency) && $editCurrency->id === $currency->id ? 'bg-blue-100 dark:bg-blue-900' : '' }}">
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $currency->id }}</td>
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $currency->name }}</td>
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $currency->code }}</td>
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $currency->sign }}</td>
                                <td class="px-4 py-2">
                                    <x-dialogs.alert-button :class="'px-4 py-2 text-red-600 dark:text-red-400 border border-red-600 dark:border-red-400 rounded hover:bg-red-600 hover:text-white transition duration-200'" :title="__('alert')" :message="__('itmDeleteMessage')"
                                        :buttonTxt="__('delete')" :rute="route('currencies.destroy', $currency->id)" :confirmtxt="__('delete')" :canceltxt="__('cancel')"
                                        :id="'modal-' . $currency->id">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                                            <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                            </svg>

                                        </div>
                                    </x-dialogs.alert-button>
                                </td>
                                <td>
                                    @if ($globalConfig->currency_id == $currency->id)
                                        <div class="relative group">
                                            <!-- SVG Icon -->
                                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M19 19.2674V7.84496C19 5.64147 17.4253 3.74489 15.2391 3.31522C13.1006 2.89493 10.8994 2.89493 8.76089 3.31522C6.57467 3.74489 5 5.64147 5 7.84496V19.2674C5 20.6038 6.46752 21.4355 7.63416 20.7604L10.8211 18.9159C11.5492 18.4945 12.4508 18.4945 13.1789 18.9159L16.3658 20.7604C17.5325 21.4355 19 20.6038 19 19.2674Z"
                                                        stroke="#2eb86a" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </g>
                                            </svg>

                                            <!-- Tooltip -->
                                            <div
                                                class="absolute bottom-full mb-4  hidden group-hover:flex items-center bg-black text-white text-sm px-3 py-1 rounded whitespace-nowrap max-w-xs sm:max-w-sm whitespace-normal group-hover:block transform rtl:-translate-x-1 ltr:-translate-x-1/2 left-[calc(50%+10px)] z-1000">
                                                {{ __('TheDefaultCurrency') }} </div>
                                        </div>
                                    @endif
                                </td>


                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    {{-- </div> --}}
</x-layouts.app>
