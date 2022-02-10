<?php

namespace App\Tution\Teacher\Services;

use Illuminate\Http\Request;

interface SchoolClassService
{
    public function getClass(Request $request);

    public function getClasses(Request $request);

    public function createClass(Request $request);

    public function updateClass(Request $request);

    public function updateClassStatus(Request $request);

    public function deleteClass(Request $request);

    public function formatClass(\App\Models\SchoolClass $class);
}
