<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Operator extends BaseController
{
    public function dashboard()
    {
        return redirect()->to('/');
    }

    public function manageAssigmentRequest()
    {
        return redirect()->to('operator/manage-assigment');
    }

    public function detailAssigment($id)
    {
        return view('operator/detail-assigment');
    }

    public function detailRequest($id)
    {
        return view('operator/detail-request');
    }

    public function detailLearningPath()
    {
        return view('operator/detail-learning-path');
    }

    public function manageCourse()
    {
        return view('operator/manage-course');
    }

    public function detailCourse()
    {
        return view('operator/detail-course');
    }
    
    public function addPreTest()
    {
        return view('operator/add-pre-test');
    }

    public function editPreTest($id)
    {
        return view('operator/edit-pre-test');
    }

    public function addPostTest()
    {
        return view('operator/add-post-test');
    }

    public function editPostTest($id)
    {
        return view('operator/edit-post-test');
    }
}