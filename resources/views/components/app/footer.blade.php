@php

    $sideBarLinks = [
        [
            'name' => 'homePage',
            'GoTo' => route('homePage'),
            'iconPath' => 'home-icon.svg',
            'iconPathDark' => 'home-icon-dark.svg',
        ],
        [
            'name' => 'cart',
            'GoTo' => route('cart'),
            'iconPath' => 'cart-icon.svg',
            'iconPathDark' => 'cart-icon-dark.svg',
        ],

        [
            'name' => 'history',
            'GoTo' => route('history'),
            'iconPath' => 'history-icon.svg',
            'iconPathDark' => 'history-icon-dark.svg',
        ],
    ];

    $developers = [
        [
            'name' => 'developer1',
            'numberToShow' => '+967 774 263 005',
            'numberToGo' => '967774263005',
            'email' => null,
        ],
        [
            'name' => 'developer2',
            'numberToShow' => '+967 714 224 54',
            'numberToGo' => '967714224954',
            'email' => 'omh179999@gmail.com',
        ],
        [
            'name' => 'developer3',
            'numberToShow' => '+967 775 216 046',
            'numberToGo' => '967775216046',
            'email' => null,
        ],
    ];
@endphp

<footer class="bg-gray-900 text-gray-300 py-10 px-4 md:px-8" dir="{{ app()->getLocale() === 'en' ? 'ltr' : 'rtl' }}">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Logo and About Section class="px-4 md:px-8"-->
        <div class="flex flex-col space-y-2 md:items-center">
            <img src="{{ asset('ai-logo.svg') }}" alt="Logo" class="h-10 mb-4">
            <p class="text-sm text-gray-400">
                {{ __('discribeSite') }}
            </p>
        </div>

        <!-- Links Section -->
        <div class="flex flex-col space-y-2 md:items-center">
            <h3 class="text-white font-semibold text-lg mb-4">{{ __('QuickLinks') }}</h3>
            @foreach ($sideBarLinks as $link)
                <a href="{{ $link['GoTo'] }}" class="hover:text-white text-sm">{{ __($link['name']) }}</a>
            @endforeach

        </div>

        <!-- Contact and Social Media -->
        <div class="flex flex-col space-y-4 md:items-center ">
            <h3 class="text-white font-semibold text-lg mb-4">{{ __('ContactUs') }}</h3>


            @foreach ($developers as $dev)
                <div>
                    <p class="text-sm text-gray-400">{{ __('DevelopedBy') }}: <strong
                            class="text-sm text-gray-400">{{ __($dev['name']) }}</strong></p>
                    <p class="text-sm text-gray-400"> {{ __('Contact') }}: <a href="tel:+{{ $dev['numberToGo'] }}"
                            class="hover:text-white text-right" dir="ltr">{{ $dev['numberToShow'] }}</a></p>
                    @if ($dev['email'] != null)
                        <p class="text-sm text-gray-400"><a
                                href="mailto:{{ $dev['email'] }}"class="hover:text-white">{{ $dev['email'] }}</a></p>
                    @endif
                    <a href="https://wa.me/{{ $dev['numberToGo'] }}" class="block  text-gray-400 hover:text-green-500"
                        aria-label="WhatsApp-{{ __('developer1') }}" target="_blank" rel="noopener">

                        <svg class="w-7 h-7 m-2" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.282c-.297-.149-1.761-.867-2.033-.964-.272-.097-.471-.148-.669.148-.198.297-.767.964-.94 1.162-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.474-.883-.788-1.48-1.762-1.653-2.06-.173-.298-.018-.459.13-.607.133-.133.297-.347.446-.52.15-.173.198-.297.297-.495.1-.198.05-.372-.025-.521-.074-.149-.669-1.608-.916-2.204-.242-.579-.487-.5-.669-.51-.173-.007-.372-.009-.572-.009-.198 0-.52.074-.792.372-.272.297-1.041 1.02-1.041 2.48 0 1.461 1.066 2.877 1.213 3.074.148.198 2.1 3.222 5.1 4.518.714.307 1.27.491 1.704.628.716.228 1.368.196 1.883.12.574-.085 1.761-.718 2.011-1.413.247-.694.247-1.286.173-1.413-.074-.128-.272-.198-.57-.347zM12.004 2C6.478 2 2 6.477 2 12c0 2.104.631 4.064 1.819 5.754L2 22l4.384-1.786A9.944 9.944 0 0 0 12.005 22C17.521 22 22 17.522 22 12S17.521 2 12.004 2zm0 18c-1.79 0-3.47-.548-4.898-1.489l-.351-.231-2.603 1.06.49-2.637-.238-.343C4.547 15.524 4 13.805 4 12 4 7.589 7.589 4 12.004 4 16.416 4 20 7.589 20 12s-3.589 8-7.996 8z" />
                        </svg>
                    </a>

                </div>
            @endforeach

        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="border-t border-gray-700 mt-10 pt-5 text-center ">
        <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ __('copyRight') }} . {{ __('appName') }}</p>
    </div>
