<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Models\Currency;
use Mayank\Alert\Alert;

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
        // Validate the incoming request to ensure 'edit' exists and is numeric
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

            return redirect()->back();
        }

        // Fetch the first Config record
        $config = Config::first();

        if (!$config) {
            Alert::failure()
                ->title('Error!')
                ->description('No configuration record found.')
                ->create();

            return redirect()->back();
        }

        // Update the currency_id in the Config record
        $config->update(['currency_id' => $editCurrency->id]);

        Alert::success()
            ->title('Success!')
            ->description('Currency updated successfully.')
            ->create();

        return redirect()->back();
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
