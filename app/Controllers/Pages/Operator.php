<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\AssignLearningPathModel;
use App\Models\CourseModel;
use App\Models\NewsModel;
use App\Models\LearningPathModel;
use App\Models\RequestLearningPathModel;
use App\Models\SubcourseModel;
use App\Models\UserLearningPathModel;
use App\Models\UsersModel;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class Operator extends BaseController
{
    protected $session;
    protected $usersModel;
    protected $newsModel;
    protected $courseModel;
    protected $categoryModel;
    protected $learningPathsModel;
    protected $subcourseModel;
    protected $userLearningPathModel;
    protected $assignLearningPathModel;
    protected $requestLearningPathModel;

    public  function __construct()
    {
        $this->session = session();
        $this->usersModel = new UsersModel();
        $this->courseModel = new CourseModel();
        $this->newsModel = new NewsModel();
        $this->categoryModel = new CategoryModel();
        $this->learningPathsModel = new LearningPathModel();
        $this->subcourseModel = new SubcourseModel();
        $this->userLearningPathModel = new UserLearningPathModel();
        $this->assignLearningPathModel = new AssignLearningPathModel();
        $this->requestLearningPathModel = new RequestLearningPathModel();
    }

    public function dashboard()
    {
        return redirect()->to('/');
    }

    public function manageAssigmentRequest()
    {
        $assign_learning_paths = $this->assignLearningPathModel->getAssignLearningPaths();
        $request_learning_paths = $this->requestLearningPathModel->getRequestLearningPaths();
        $users = $this->usersModel->getUsersInUserRole();
        // dd($assign_learning_paths);
        $learningPaths = $this->learningPathsModel->findAll();
        $data = [
            'assign_learning_paths' => $assign_learning_paths,
            'request_learning_paths' => $request_learning_paths,
            'users' => $users,
            'learningPaths' => $learningPaths
        ];
        return view('operator/manage-assignment-request', $data);
    }

    public function detailAssignment($id)
    {
        $detailAssignment = $this->assignLearningPathModel->getDetailAssignLearningPath($id);
        if (!$detailAssignment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'detailAssignment' => $detailAssignment
        ];
        return view('operator/detail-assigment', $data);
    }

    public function detailRequest($id)
    {
        $detailRequest = $this->requestLearningPathModel->getDetailRequestLearningPath($id);
        if (!$detailRequest) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'detailRequest' => $detailRequest
        ];
        return view('operator/detail-request', $data);
    }

    public function detailLearningPath($slug)
    {
        $learningPaths = $this->learningPathsModel->where('slug', $slug)->first();
        if (!$learningPaths) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // $courses = $this->courseModel->where('learning_path_id', $learningPaths['id'])->orderBy('sequence', 'ASC')->findAll();
        $data = [
            'learningPaths' => $learningPaths
            // 'courses' => $courses
        ];
        return view('operator/detail-learning-path', $data);
    }

    public function manageCourse()
    {
        $courses = $this->courseModel->findAll();
        $learningPaths = $this->learningPathsModel->findAll();

        $data = [
            'courses' => $courses,
            'learningPaths' => $learningPaths
        ];
        return view('operator/manage-course', $data);
    }

    public function detailCourse($slug)
    {
        $course = $this->courseModel->where('slug', $slug)->first();
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $subcourses = $this->subcourseModel->where('course_id', $course['id'])->orderBy('sequence', 'ASC')->findAll();
        $hasPreTest = count(array_filter($subcourses, function($subcourse) {
            return $subcourse['title'] === 'Pre Test';
        })) > 0;
        $hasPostTest = count(array_filter($subcourses, function($subcourse) {
            return $subcourse['title'] === 'Post Test';
        })) > 0;
        $data = [
            'course' => $course,
            'subcourses' => $subcourses,
            'hasPostTest' => $hasPostTest,
            'hasPreTest' => $hasPreTest
        ];
        // dd($data);
        return view('operator/detail-course', $data);
    }
    
    public function addPreTest($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $subcourses = $this->subcourseModel->where('course_id', $id)->where('title', 'Pre Test')->first();
        if ($subcourses) {
            return redirect()->to('/edit-pre-test/' . $course['id']);
        }
        $data = [
            'course_id' => $id
        ];

        return view('operator/add-pre-test',$data);
    }

    public function editPreTest($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'course_id' => $id
        ];
        return view('operator/edit-pre-test', $data);
    }

    public function addPostTest($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $subcourses = $this->subcourseModel->where('course_id', $id)->where('title', 'Post Test')->first();
        if ($subcourses) {
            return redirect()->to('/edit-post-test/' . $course['id']);
        }
        $subcourses_sequence = $this->subcourseModel->where('course_id', $course['id'])->orderBy('sequence', 'ASC')->findAll();
        $data = [
            'course_id' => $id,
            'subcourses_sequence' => $subcourses_sequence
        ];
        return view('operator/add-post-test', $data);
    }

    public function editPostTest($id)
    {
        return view('operator/edit-post-test');
    }

    public function manageNews()
    {
        $news = $this->newsModel->findAll();
        $categories = $this->categoryModel->findAll();
        $data = [
            'news' => $news,
            'categories' => $categories
        ];
        return view('operator/manage-news', $data);
    }

    public function detailNews($slug)
    {
        $news = $this->newsModel->where('slug', $slug)->first();
        $category_news = $this->categoryModel->where('id', $news['category_id'])->first();
        $categories = $this->categoryModel->findAll();
        if (!$news) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'news' => $news,
            'category_news' => $category_news['name'],
            'categories' => $categories
        ];
        return view('operator/detail-news', $data);
    }

}