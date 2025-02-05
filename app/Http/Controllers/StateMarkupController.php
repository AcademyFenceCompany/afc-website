<?php

namespace App\Http\Controllers;

use App\Models\StateMarkup;
use Illuminate\Http\Request;

class StateMarkupController extends Controller
{
    public function index()
    {
        $stateMarkups = StateMarkup::all();

        return view('ams.shipping.shipping-markup', compact('stateMarkups'));
    }


    public function update(Request $request, $id)
    {
    $request->validate([
        'markup' => 'required|numeric|min:0',
    ]);

    $stateMarkup = StateMarkup::findOrFail($id);
    $stateMarkup->markup = $request->markup;
    $stateMarkup->save();

    return response()->json(['success' => true]);
    }

    public function getMarkup($state)
    {
        $stateMarkup = StateMarkup::where('state', $state)->first();

        if ($stateMarkup) {
            return response()->json(['markup' => $stateMarkup->markup]);
        }

        return response()->json(['markup' => 0]); // Default to 0 if no markup found
    }


}
