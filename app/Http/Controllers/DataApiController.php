<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\Data;

class DataApiController extends Controller
{

    public function getData(Request $request):JsonResponse
    {
        $user = User
            ::where('api_token', $request->route('token'))
            ->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'wrong token',
            ]);
        }

        $data = Data
            ::where('id', $request->route('data_id'))
            ->where('user', $user['id'])
            ->limit(1)
            ->get(['value'])
            ->toArray();

        if (!isset($data[0]['value'])) {
            return response()->json([
                'status' => false,
                'message' => 'wrong data id',
            ]);
        }

        $termsList = preg_split("/\r\n|\n|\r/", $data[0]['value']);
        $resultTerms = [];
        foreach ($termsList as $term) {
            $explodedTerm = explode('|', $term);
            if (!empty($explodedTerm[1])) {
                $resultTerms[$explodedTerm[0]] = $explodedTerm[1];
            } else {
                $resultTerms[] = $term;
            }
        }

        return response()->json([
            'status' => true,
            'value' => $resultTerms
        ]);
    }
}
