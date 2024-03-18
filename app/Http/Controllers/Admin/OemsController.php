<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oems;
use App\Models\OemSettings;

class OemsController extends Controller
{
    public function saveOneData(Request $request)
    {
        $one = Oems::create([
            'name' => $request->input('one_name'),
            // Add other attributes from the request data if needed
        ]);

        return response()->json(['message' => 'Oems data inserted successfully'], 201);
    }

    public function saveOemSettingsData(Request $request)
    {
        // Validate the incoming request data for "OemSettings" model
        $request->validate([
            // Add validation rules for "OemSettings" model attributes
        ]);

        // Create a new "OemSettings" instance and set its attributes from the request data
        $oemSettings = OemSettings::create([
            // Add attributes from the request data for "OemSettings" model
        ]);

        // Optionally, you can return a response indicating success or redirect to another page
        return response()->json(['message' => 'OemSettings data inserted successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $oemsSetting = OemsSetting::findOrFail($id);

        $request->validate([
            'groupCode' => 'required|string',
            'oemCode' => 'required|exists:one,oemCode',
        ]);

        $oemsSetting->update($request->all());

        return response()->json($oemsSetting, 200);
    }

    public function destroy($id)
    {
        $oemsSetting = OemsSetting::findOrFail($id);
        $oemsSetting->delete();

        return response()->json(null, 204);
    }
}
