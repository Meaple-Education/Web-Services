<?php

namespace App\Tution\Teacher\Services;

use Illuminate\Http\Request;

interface SchoolService
{
    public function getSchools(Request $request);

    public function getSchool(Request $request);

    public function createSchool(Request $request);

    public function updateSchool(Request $request);

    public function updateSchoolStatus(Request $request);

    public function deleteSchool(Request $request);

    public function formatSchool(\App\Models\School $school);
}
