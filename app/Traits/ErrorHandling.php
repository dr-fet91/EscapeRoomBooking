<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ErrorHandling{
    protected function errorResponse(\Throwable $th): Response{
        $code = (int) @$th->getCode();
        if ($code < 100 || $code > 500) {
            $code = 500;
        }
        return response([
            'message' => $th->getMessage(),
            'data' => false
        ], $code);
    }
}