<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class VoteController extends Controller
{
    public function __invoke(Request $request, Resource $resource)
    {
        // buscar o crear el votante
        //toogle del voto
        //devolver el resource actualizado con su recuento de voto

        $voterId = $request->cookie('voter_code');
        $voter = Voter::where('code', $voterId)->first();
        if(!$voter){
            $voter = Voter::create([
                'code' => Str::random(30),
            ]);
            Cookie::queue('voter_code',$voter->code, 60 * 24 * 30);
        }
        // toogle
        $resource->votes()->toggle($voter->id);
        // devuekve el  resource actualizado con su recuento de voto

        return $resource->load('votes','category');

    }
}
