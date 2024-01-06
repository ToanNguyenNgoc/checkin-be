<?php
namespace App\Repositories\User;

use App\Repositories\Repository;

class UserRepository extends Repository implements UserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function checkValidUserStatusByEmail($email)
    {
        $query = $this->model->whereIn('status', $this->model->getStatuesValid());
        $query = $query->where('email', $email);
        return $query->first();
    }
}
