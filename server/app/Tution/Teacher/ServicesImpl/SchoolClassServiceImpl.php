<?php

namespace App\Tution\Teacher\ServicesImpl;

use App\Tution\Repositories\SchoolClassRepository;
use App\Tution\Teacher\Services\SchoolClassService;
use Illuminate\Http\Request;

class SchoolClassServiceImpl implements SchoolClassService
{
    private $repo;

    public function __construct(SchoolClassRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getClasses(Request $request)
    {
        $getClasses = $this->repo->get($request->schoolID);

        $list = [];

        foreach ($getClasses  as $class) {
            $list[] = $this->formatClass($class);
        }

        return [
            'status' => true,
            'code' => 200,
            'data' => [
                'list' => $list,
            ],
            'msg' => 'Success.',
        ];
    }

    public function getClass(Request $request)
    {
        $getClass = $this->repo->getOne($request->classID);

        return [
            'status' => true,
            'code' => 200,
            'data' => [
                'info' => $this->formatClass($getClass),
            ],
            'msg' => 'Success.',
        ];
    }

    public function createClass(Request $request)
    {
        $input = $request->only(
            'name',
            'description'
        );

        $input['school_id'] = $request->schoolID;

        $createClass = $this->repo->create($input);

        if ($createClass['status']) {
            $createClass['data'] = [
                'info' => $this->formatClass($createClass['data']['info']),
            ];
        }

        return $createClass;
    }

    public function updateClass(Request $request)
    {
        $input = $request->only(
            'name',
            'description'
        );

        return $this->repo->update($request->classID, $input);
    }

    public function updateClassStatus(Request $request)
    {
        $input = $request->only(
            'status'
        );

        return $this->repo->updateStatus($request->classID, $input);
    }

    public function deleteClass(Request $request)
    {
    }

    public function formatClass(\App\Models\SchoolClass $class)
    {
        return $class->toArray();
    }
}
