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
        $voter = Voter::getOrCreateVoter($request);

        // toogle
        $resource->votes()->toggle($voter->id);
        // devuekve el  resource actualizado con su recuento de voto

        return $resource->load('votes','category');

    }
}
