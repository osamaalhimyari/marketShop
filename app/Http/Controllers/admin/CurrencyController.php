<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Models\Currency;
use Mayank\Alert\Alert;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View; // To share data with all views
use Illuminate\Support\Facades\Log;
class CurrencyController extends Controller
{


    public function index(Request $request)
    {
        $currencies = Currency::all();
        $editCurrency = null;

        if ($request->has('edit')) {
            $editCurrency = Currency::findOrFail($request->edit);
        }

        return view('admin.Currencies-page', compact('currencies', 'editCurrency'));
    }
public function setDefault(Request $request)
{
    try {
        // Validate the incoming request
        $request->validate([
            'edit' => 'required|integer|exists:currencies,id',
        ]);

        // Find the currency to set as default
        $editCurrency = Currency::find($request->edit);

        if (!$editCurrency) {
            Alert::failure()
                ->title('Error!')
                ->description('Currency not found.')
                ->create();

            return back();
        }

        // Fetch the first Config record
        $config = Config::first();

        if (!$config) {
            Alert::failure()
                ->title('Error!')
                ->description('No configuration record found.')
                ->create();

            return back();
        }

        // Update the currency_id in the Config record
        $config->update(['currency_id' => $editCurrency->id]);

        // Clear and repopulate the globalConfig cache
        Cache::forget('globalConfig');

        $updatedConfig = Cache::remember('globalConfig', 3600, function () {
            return Config::with(['currency'])->first();
        });

        if (!$updatedConfig) {
            throw new \Exception("Failed to cache or fetch the updated configuration.");
        }

        // Share the updated config with all views
        View::share('globalConfig', $updatedConfig);

        Alert::success()
            ->title('Success!')
            ->description('Currency updated successfully.')
            ->create();

        return back();

    } catch (\Throwable $e) {
        // Log the error for debugging
        log::error('Error in setDefault function: ' . $e->getMessage());

        Alert::failure()
            ->title('Error!')
            ->description('An unexpected error occurred. Please try again later.')
            ->create();

        return back();
    }
}



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
            'sign' => 'required|string|max:3',
        ]);

        Currency::create([
            'name' => $request->name,
            'code' => $request->code,
            'sign' => $request->sign,
        ]);

        return redirect()->route('currencies.index')->with('success', 'Currency added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3',
            'sign' => 'required|string|max:3',
        ]);

        $currency = Currency::findOrFail($id);
        $currency->update([
            'name' => $request->name,
            'code' => $request->code,
            'sign' => $request->sign,
        ]);

        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    public function destroy($id)
    {
        Currency::findOrFail($id)->delete();
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
