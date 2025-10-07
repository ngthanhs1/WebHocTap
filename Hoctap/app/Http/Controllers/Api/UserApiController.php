<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function jsonInputPostUser(Request $request)
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!is_array($data)) {
            $data = $request->all();
        }

        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;

        return response()->json([
            'json_post_success' => true,
            'name' => $name,
            'email' => $email,
        ]);
    }
}
