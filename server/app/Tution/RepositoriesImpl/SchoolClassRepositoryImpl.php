<?php

namespace App\Tution\RepositoriesImpl;

use DB;

use App\Models\SchoolClass;
use App\Tution\Repositories\SchoolClassRepository;

class SchoolClassRepositoryImpl implements SchoolClassRepository
{

    public function get($schoolID)
    {
        return SchoolClass::where('school_id', $schoolID)
            ->get();
    }

    public function getOne($id)
    {
        return SchoolClass::find($id);
    }

    public function create($input)
    {
        $res = [
            'status' => true,
            'code' => 201,
            'data' => [],
            'msg' => 'Success.',
        ];

        DB::beginTransaction();

        try {
            $res['data']['info'] = SchoolClass::create([
                'name' => $input['name'],
                'description' => $input['description'],
                'school_id' => $input['school_id'],
                'status' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to create class!',
            ];

            if (config('app.debug')) {
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
            }

            return $res;
        }

        DB::commit();

        return $res;
    }

    public function update($id, $input)
    {
        $res = [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ];

        DB::beginTransaction();

        try {
            $class = $this->getOne($id);
            $class->name = $input['name'];
            $class->description = $input['description'];
            $class->update();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to update class!',
            ];

            if (config('app.debug')) {
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
            }

            return $res;
        }

        DB::commit();

        return $res;
    }

    public function updateStatus($id, $input)
    {
        $res = [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success.',
        ];

        DB::beginTransaction();

        try {
            $class = $this->getOne($id);
            $class->status = $input['status'];
            $class->update();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to update class status!',
            ];

            if (config('app.debug')) {
                // @codeCoverageIgnoreStart
                $res['error']['msg'] = $e->getMessage();
                $res['error']['stack'] = $e->getTrace();
                // @codeCoverageIgnoreEnd
            }

            return $res;
        }

        DB::commit();

        return $res;
    }

    public function delete($id, $input)
    {
    }
}
