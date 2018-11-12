<?php

namespace App\Http\Controllers\Api\v1;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class RestController extends BaseController {

    protected $data = [];
    
    function __construct(){}

    protected function error(int $code, string $message = '', $data = []) : JsonResponse{
        return $this->json($data)->setStatusCode($code, $message);
    }

    protected function success($data = []) : JsonResponse{
        return $this->json($data);
    }

    protected function json($data) : JsonResponse{
        return response()->json($data);
    }
    
    function buildTree($elements, $parentId = 0, $nameVariable = 'parent_id') {
        $branch = [];

        foreach ($elements as $element) {
            if ($element->$nameVariable == $parentId) {
                $children = $this->buildTree($elements, $element->id);
                if ($children) {
                    $element->child = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
}