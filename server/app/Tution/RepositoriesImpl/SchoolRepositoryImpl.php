<?php

namespace App\Tution\RepositoriesImpl;

use DB;

use App\Models\School;
use App\Tution\Repositories\SchoolRepository;

class SchoolRepositoryImpl implements SchoolRepository
{
    function getOne($id)
    {
        return School::find($id);
    }

    function getByOwner($ownerID, $pagination = 10)
    {
        return School::where('user_id', $ownerID)
            ->paginate($pagination);
    }

    function get($pagination = 10)
    {
        return School::paginate($pagination);
    }

    function create($input)
    {
        $school = null;

        DB::beginTransaction();

        try {
            $school = School::create([
                'name' => $input['name'],
                // 'logo' => $input['logo'],
                'description' => $input['description'],
                'address' => $input['address'],
                'phone_numbers' => $input['phone_numbers'],
                'user_id' => $input['user_id'],
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to create school!',
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

        return [
            'status' => true,
            'code' => 201,
            'data' => $school,
            'msg' => 'Success.',
        ];
    }

    function update($id, $input)
    {
        $res = [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success',
        ];

        DB::beginTransaction();

        try {
            $school = $this->getOne($id);
            $school->name = $input['name'];
            // $school->logo = $input['logo'];
            $school->description = $input['description'];
            $school->address = $input['address'];
            $school->phone_numbers = $input['phone_numbers'];
            $school->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to update school info!',
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

    function updateStatus($id, $status)
    {
        $res = [
            'status' => true,
            'code' => 200,
            'data' => [],
            'msg' => 'Success',
        ];

        DB::beginTransaction();

        try {
            $school = $this->getOne($id);
            $school->status = (int) $status === 1;
            $school->save();
        } catch (\Exception $e) {
            DB::rollback();
            $res = [
                'status' => false,
                'code' => 422,
                'data' => [],
                'msg' => 'Failed to update school status!',
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

    function softDelete($id)
    {
    }

    function delete($id)
    {
    }
}
