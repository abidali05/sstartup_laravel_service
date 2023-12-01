<?php

namespace App\Services;

use App\Helper\BaseQuery;
use App\Helper\ImageUpload;
use App\Models\User;

class UserService
{
    use BaseQuery, ImageUpload;

    private $_imgPath = 'users/';

    private $_model = null;

    public function __construct()
    {
        $this->_model = new User();
    }

    public function index()
    {
        return $this->_model->whereHas('roles', function ($q) {
            $q->where('name', '!=', 'admin');
        })->get();
    }

    public function store($data)
    {
        return $this->add($this->_model, $data);
    }


    public function show($id)
    {
        return $this->get_by_id($this->_model, $id);
    }

    public function update($id, $data)
    {
        unset($data['email']);

        $user = $this->get_by_id($this->_model, $id);

        if (request()->hasFile('image')) {
            if ($user->images != null) {
                $this->deleteImage($user->images->url);
                $user->images()->delete();
            }

            $imageUploaded = $this->uploadImage($data['image'], $this->_imgPath);
            $user->images()->create($imageUploaded);
        }

        return $user->update($data);
    }

    public function destroy($id)
    {
        return $this->delete($this->_model, $id);
    }

    private function validateEmail($email)
    {
        $this->get_by_column_single($this->_model, ['email' => $email]);

        if ($email != null) {
            return false;
        } else {
            return true;
        }
    }
}
