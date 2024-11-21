  <div class="md:col-span-1 bg-white dark:bg-gray-800 p-6 mt-6  mr-2 ml-2 rounded-lg shadow-lg">
      <h3 class="text-xl font-bold mb-5">{{ __('summary') }}</h3>
      <hr class="my-4">
      <div class="flex  mb-5">
          <h5 class="text-uppercase pl-10 font-bold">{{ __('productsCount') }}:</h5>
          <h5 class="summary-ProductsCount  font-bold" id="summary-ProductsCount">0</h5>
      </div>


      <hr class="my-4">

      <div class="flex  mb-5">
          <h5 class="text-uppercase pl-10 font-bold">{{ __('totalPrice') }}:</h5>
          <h5 class="total-price  font-bold text-green-700" id="total-price">{{ $globalConfig->currency->sign }} 0.00
          </h5>
      </div>
      <hr class="my-4">
      <form id="orderForm" onsubmit="submitOrder(event)" method="POST">
          @csrf

          <div>
              <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white p-3 ">
                  {{ __('fullname') }}</label>
              <div class="mt-2">
                  <input type="text" id="name" name="name" placeholder="Enter your name" required
                      class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 ">
              </div>
          </div>

          <div>
              <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white p-3">
                  {{ __('address') }}</label>
              <div class="mt-2">

                  <input type="text" id="address" name="address" placeholder="Enter your adress" required
                      class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>
          </div>
          <button id="buttonOfInvoice" type="submit" disabled
              class="w-full bg-blue-600 text-white py-2 rounded-lg mt-6">

              {{ __('submitOrder') }}
          </button>
      </form>


  </div>
