<?php

namespace App\Tution\Teacher\ServicesImpl;

use App\Tution\Repositories\SchoolRepository;
use App\Tution\Teacher\Services\SchoolService;
use Illuminate\Http\Request;

class SchoolServiceImpl implements SchoolService
{
    private $repo;

    public function __construct(SchoolRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getSchools(Request $request)
    {
        $schools = $this->repo->getByOwner($request->user()->id);

        $list = [];

        foreach ($schools as $school) {
            $list[] = $this->formatSchool($school);
        }

        return [
            'status' => true,
            'code' => 200,
            'data' => [
                'list' => $list,
            ],
            'msg' => 'Success',
        ];
    }

    public function getSchool(Request $request)
    {
        $school = $this->repo->getOne($request->schoolID);
        return [
            'status' => true,
            'code' => 200,
            'data' => [
                'info' => $this->formatSchool($school),
            ],
            'msg' => 'Success'
        ];
    }

    public function createSchool(Request $request)
    {
        $input = $request->only(
            'name',
            'description',
            'address',
            'phone_numbers'
        );

        $input['user_id'] = $request->user()->id;

        $createSchool = $this->repo->create($input);

        if ($createSchool['status']) {
            $createSchool['data'] = $this->formatSchool($createSchool['data']);
        }

        return $createSchool;
    }

    public function updateSchool(Request $request)
    {
        $input = $request->only(
            'name',
            'description',
            'address',
            'phone_numbers'
        );

        $updateSchool = $this->repo->update($request->schoolID, $input);

        return $updateSchool;
    }

    public function updateSchoolStatus(Request $request)
    {
        $updateSchoolStatus = $this->repo->updateStatus($request->schoolID, $request->input('status'));

        return $updateSchoolStatus;
    }

    public function deleteSchool(Request $request)
    {
        return $this->repo->delete($request->schoolID);
    }

    public function formatSchool(\App\Models\School $school)
    {
        $school->phone_numbers = json_decode($school->phone_numbers);
        // $school->deleted_at = (string) $school->deleted_at;
        // $school->created_at = (string) $school->created_at;
        // $school->updated_at = (string) $school->updated_at;
        return $school->toArray();
    }
}
