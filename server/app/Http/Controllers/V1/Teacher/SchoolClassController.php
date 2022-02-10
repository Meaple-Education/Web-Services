<?php

namespace App\Http\Controllers\V1\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Teacher\SchoolClass\CreateClassRequest;
use App\Http\Requests\V1\Teacher\SchoolClass\UpdateClassRequest;
use App\Http\Requests\V1\Teacher\SchoolClass\UpdateClassStatusRequest;
use App\Tution\Teacher\Services\SchoolClassService;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    private $service;

    public function __construct(SchoolClassService $service)
    {
        $this->service = $service;
    }

    public function getClasses(Request $request)
    {
        $getClasses = $this->service->getClasses($request);
        return response()->json($getClasses, $getClasses['code']);
    }

    public function getClass(Request $request)
    {
        $getClass =  $this->service->getCLass($request);
        return response()->json($getClass, $getClass['code']);
    }

    public function createClass(CreateClassRequest $request)
    {
        $createClass = $this->service->createClass($request);
        return response()->json($createClass, $createClass['code']);
    }

    public function updateClass(UpdateClassRequest $request)
    {
        $updateClass = $this->service->updateClass($request);
        return response()->json($updateClass, $updateClass['code']);
    }

    public function updateClassStatus(UpdateClassStatusRequest $request)
    {
        $updateClassStatus = $this->service->updateClassStatus($request);
        return response()->json($updateClassStatus, $updateClassStatus['code']);
    }
}
