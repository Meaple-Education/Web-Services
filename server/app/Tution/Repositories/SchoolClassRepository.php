<?php

namespace App\Tution\Repositories;

interface SchoolClassRepository
{
    public function get($schoolID);

    public function getOne($id);

    public function create($input);

    public function update($id, $input);

    public function updateStatus($id, $input);

    public function delete($id, $input);
}
