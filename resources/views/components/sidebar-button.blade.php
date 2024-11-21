<li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0" x-data="{ open: false }">
    <a class="block text-gray-800 dark:text-gray-100 truncate transition"
        :class="open ? '' : 'hover:text-gray-900 dark:hover:text-white'" href="{{ $slideBarLink['GoTo'] }}">
        <div class="flex items-center justify-between ">
            <div class="flex items-center">

                <img src="{{ asset('svg/' . $slideBarLink['iconPath']) }}" alt=""
                    class="block dark:hidden shrink-0 fill-current text-gray-400 dark:text-gray-500" width="20"
                    height="20" viewBox="0 0 16 16">
                <img src="{{ asset('svg/' . $slideBarLink['iconPathDark']) }}" alt=""
                    class="hidden dark:block shrink-0 fill-current text-gray-400 dark:text-gray-500" width="20"
                    height="20" viewBox="0 0 16 16">


                <span
                    class="text-sm font-medium ml-4 mr-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 ">{{ __($slideBarLink['name']) }}</span>

            </div>

        </div>
    </a>

</li>
