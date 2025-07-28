<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function update(Request $request)
    {
        $request->user()->update($request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'gender' => 'sometimes|string|in:male,female,other',
            'birth_year' => 'sometimes|integer',
            'school' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'facebook_link' => 'sometimes|string|max:255',
        ]));

        return response()->json([
            'message' => $request->user(),
        ]);
    }
}
