<?php

namespace App\Utils;

use Illuminate\Http\Request;

class RequestHelpers{
    public static function mergeRouteParameters(Request $request,Array $names){
        $parameters = [];
        foreach ($names as $name) {
            if ($request->route($name)) {
                $parameters[$name] = $request->route($name);
            }
        }

        // Hacer una sola llamada a merge() para todos los parámetros
        if (!empty($parameters)) {
            $request->merge($parameters);
        }
    }
}
