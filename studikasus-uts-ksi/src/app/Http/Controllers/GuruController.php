<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EncryptionHelper;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $guru = $request->get('authenticated_guru');
        $data = $guru->get();
        $encryptedResponse = EncryptionHelper::encrypt(json_encode($data));
        return response()->json(['data' => $encryptedResponse]);
    }
}
