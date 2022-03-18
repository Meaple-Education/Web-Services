<?php

namespace App\Http\Controllers\V1\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Teacher\School\CreateSchoolRequest;
use App\Http\Requests\V1\Teacher\School\UpdateSchoolRequest;
use App\Http\Requests\V1\Teacher\School\UpdateSchoolStatusRequest;
use App\Tution\Teacher\Services\SchoolService;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    private $service;

    public function __construct(SchoolService $service)
    {
        $this->service = $service;
    }

    function createSchool(CreateSchoolRequest $request)
    {
        $creatSchool = $this->service->createSchool($request);

        return response()->json($creatSchool, $creatSchool['code']);
    }

    function getSchools(Request $request)
    {
        $getSchools = $this->service->getSchools($request);

        return response()->json($getSchools, $getSchools['code']);
    }

    function getSchool(Request $request)
    {
        $getSchool = $this->service->getSchool($request);

        return response()->json($getSchool, $getSchool['code']);
    }

    function updateSchool(UpdateSchoolRequest $request)
    {
        $updateSchool = $this->service->updateSchool($request);

        return response()->json($updateSchool, $updateSchool['code']);
    }

    function updateSchoolStatus(UpdateSchoolStatusRequest $request)
    {
        $updateSchoolStatus = $this->service->updateSchoolStatus($request);

        return response()->json($updateSchoolStatus, $updateSchoolStatus['code']);
    }

    function deleteSchool(Request $request)
    {
        $deleteSchool = $this->service->deleteSchool($request);

        return response()->json($deleteSchool, $deleteSchool['code']);
    }
}
