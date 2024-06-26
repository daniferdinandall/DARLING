<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\LearningPathModel;
use App\Models\CourseModel;
use App\Models\SubcourseModel;
use App\Models\WrittenMaterialModel;
use App\Models\VideoMaterialModel;
use App\Models\TestMaterialModel;
use App\Models\OptionTestModel;
use App\Models\LearningPathCourseModel;
use App\Models\UserLearningPathModel;
use App\Models\RequestLearningPathModel;
use App\Models\AssignLearningPathModel;
use App\Models\UsersModel;
use App\Models\CategoryModel;
use App\Models\NewsModel;
use App\Models\RoleModel;
use CodeIgniter\I18n\Time;

class Operator extends BaseController
{
    protected $session;
    protected $courseModel;
    protected $learningpathModel;
    protected $newsModel;


    public function __construct()
    {
        $this->session = session();
        $this->newsModel = new NewsModel();
        $this->courseModel = new CourseModel();
        $this->learningpathModel = new LearningPathModel();
    }

    // Courses |check
    public function createCourse()
    {
        $rules = [
            'course_name'          => 'required',
            'course_description'   => 'required',
            'skill_type'           => 'required',
            'course_type'          => 'required',
            'module'               => 'uploaded[module]|max_size[module,5120]',
            'course_thumbnail'     => 'uploaded[course_thumbnail]|max_size[course_thumbnail,5120]|is_image[course_thumbnail]|mime_in[course_thumbnail,image/jpg,image/jpeg,image/png]',
        ];

        $slug = url_title($this->request->getVar('course_name'), '-', true);
        if ($this->courseModel->where('slug', $slug)->first() != null) {
            $this->session->setFlashdata('msg-failed', 'Judul course sudah ada');
            return redirect()->to('manage-course');
        }

        if ($this->validate($rules)) {
            $thumbnail = $this->request->getFile('course_thumbnail');
            $thumbnail->move('images-thumbnail');
            $nameThumbnail = $thumbnail->getName();

            $module = $this->request->getFile('module');
            $module->move('module-course');
            $nameModule = $module->getName();

            $data = [
                'thumbnail'     => $nameThumbnail,
                'name'          => $this->request->getVar('course_name'),
                'slug'          => $slug,
                'description'   => $this->request->getVar('course_description'),
                'module'        => $nameModule,
                'skill_type'    => $this->request->getVar('skill_type'),
                'course_type'   => $this->request->getVar('course_type'),
                'status'        => 'draft',
                'published_at'  => null,
            ];

            $this->courseModel->save($data);
            $this->session->setFlashdata('msg', 'Berhasil menambahkan course baru');
            return redirect()->to('detail-course/' . $slug);
        } else {;
            $validation = $this->validator;
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    // check
    public function updateCourse($id)
    {
        $course = $this->courseModel->find($id);
        if ($course == null) {
            $this->session->setFlashdata('msg-failed', 'Course tidak ditemukan');
            return redirect()->back();
        }
        $slug = url_title($this->request->getVar('course_name'), '-', true);
        $exists_slug = $this->courseModel->where('slug', $slug)->first();
        if ($exists_slug != null && $exists_slug['id'] != $id) {
            $this->session->setFlashdata('msg-failed', 'Judul course sudah ada');
            return redirect()->to('detail-course/' . $course['slug']);
        }

        $rules = [
            'course_name'          => 'required',
            'course_description'   => 'required',
            'module'               => 'max_size[module,5120]',
            'course_thumbnail'     => 'max_size[course_thumbnail,5120]|is_image[course_thumbnail]|mime_in[course_thumbnail,image/jpg,image/jpeg,image/png]',
        ];

        if ($this->validate($rules)) {
            $thumbnail = $this->request->getFile('course_thumbnail');
            //cek thumbnail lama
            if ($thumbnail->getError() == 4) {
                $nameThumbnail = $this->request->getVar('old_course_thumbnail');
            } else {
                $thumbnail->move('images-thumbnail');
                $nameThumbnail = $thumbnail->getName();
                if ($this->request->getVar('old_course_thumbnail')) {
                    if (file_exists('images-thumbnail/' . $this->request->getVar('old_course_thumbnail'))) {
                        if ($this->request->getVar('old_course_thumbnail') != 'base_thumbnail.jpg') {
                            unlink('images-thumbnail/' . $this->request->getVar('old_course_thumbnail'));
                        }
                    }
                }
            }

            $module = $this->request->getFile('module');
            //cek module lama
            if ($module->getError() == 4) {
                $nameModule = $this->request->getVar('old_module');
            } else {
                $module->move('module-course');
                $nameModule = $module->getName();
                if ($this->request->getVar('old_module')) {
                    if (file_exists('module-course/' . $this->request->getVar('old_module'))) {
                        if ($this->request->getVar('old_module') != 'base_module.pdf') {
                            unlink('module-course/' . $this->request->getVar('old_module'));
                        }
                    }
                }
            }

            $data = [
                'thumbnail'     => $nameThumbnail,
                'name'          => $this->request->getVar('course_name'),
                'slug'          => $slug,
                'description'   => $this->request->getVar('course_description'),
                'module'        => $nameModule,
                'skill_type'    => $this->request->getVar('skill_type'),
                'course_type'   => $this->request->getVar('course_type'),
                'status'        => 'draft',
                'published_at'  => null,
            ];

            $this->courseModel->update($id, $data);
            $this->session->setFlashdata('msg', 'Berhasil mengubah course');
            return redirect()->to('detail-course/' . $slug);
        } else {
            $validation = $this->validator;
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    // check
    public function deleteCourse($id)
    {
        $course = $this->courseModel->find($id);
        if ($course == null) {
            $this->session->setFlashdata('msg-failed', 'Course tidak ditemukan');
            return redirect()->back();
        }
        if (file_exists('images-thumbnail/' .  $course['thumbnail'])) {
            if ($course['thumbnail'] != 'base_thumbnail.jpg') {
                unlink('images-thumbnail/' . $course['thumbnail']);
            }
        }

        if (file_exists('module-course/' . $course['module'])) {
            if ($course['module'] != 'base_module.pdf') {
                unlink('module-course/' . $course['module']);
            }
        }

        $this->courseModel->delete($id);
        $this->session->setFlashdata('msg', 'Berhasil menghapus course');
        return redirect()->to('manage-course');
    }

    // check
    public function updateSubcourseSequence() // update urutan subcourse pada course
    {
        /** @var string|null $jsonData */
        $jsonData = $this->request->getPost('result');
        $contentArray = json_decode($jsonData, true);
        $validationData['result'] = $contentArray;

        $rules = [
            'result.*.id' => 'required|numeric',
            'result.*.sequence' => 'required|numeric',
        ];

        if ($this->validateData($validationData, $rules)) {
            $model = new SubcourseModel();
            foreach ($contentArray as $course) {
                $data = [
                    'sequence' => $course['sequence'],
                ];
                $model->update($course['id'], $data);
            }
        } else {
            $validation = $this->validator;
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->session->setFlashdata('msg', 'Berhasil mengubah urutan subcourse');
        return redirect()->back();
    }

    // not yet
    public function publishCourse($id)
    {
        $course = $this->courseModel->find($id);
        if ($course == null) {
            $this->session->setFlashdata('msg-failed', 'Course tidak ditemukan');
            return redirect()->back();
        }
        if ($course['status'] == 'publish') {
            $this->session->setFlashdata('msg-failed', 'Course sudah dipublish');
            return redirect()->back();
        }
        $data = [
            'status' => 'publish',
            'published_at' => Time::now(),
        ];
        $this->courseModel->update($id, $data);
        return redirect()->to('detail-course/' . $course['slug']);
    }

    public function unpublishCourse($id)
    {
        $course = $this->courseModel->find($id);
        if ($course == null) {
            $this->session->setFlashdata('msg-failed', 'Course tidak ditemukan');
            return redirect()->back();
        }
        if ($course['status'] != 'publish') {
            $this->session->setFlashdata('msg-failed', 'Course masih belum dipublish');
            return redirect()->back();
        }
        $data = [
            'status' => 'draft',
            'published_at' => null,
        ];
        $this->courseModel->update($id, $data);
        return redirect()->to('detail-course/' . $course['slug']);
    }

    // Sub Courses | not all
    public function createSubCourse()
    {
        $validationRules = [
            'course_id' => 'required|numeric',
            'sequence'  => 'required|numeric',
            'type' => 'required|in_list[video,test,written]',
            'content'   => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'The {field} field is required.'
                ],
            ],
        ];
        $validationData = $this->request->getPost();
        // Additional rules based on 'type'
        $type = $this->request->getVar('type');
        $title = $this->request->getVar('title');
        if ($type === 'video') {
            $validationRules['title'] = 'required';
            $validationRules['content'] = 'required|string';
        } elseif ($type === 'written') {
            $validationRules['title'] = 'required';
            $validationRules['content'] = 'required|string';
        } elseif ($type === 'test') {
            /** @var string|null $jsonData */
            $jsonData = $this->request->getPost('content');
            $contentArray = json_decode($jsonData, true);

            // $validationRules['content.*'] = 'required';
            $validationRules['content.dataTest.*.sequence'] = 'required|integer';
            $validationRules['content.dataTest.*.content'] = 'required|string';
            // $validationRules['content.*.options.*'] = 'required';
            $validationRules['content.dataTest.*.options.*.answer'] = 'required|string';
            $validationRules['content.dataTest.*.options.*.correct'] = 'required|integer';
            // $validationData = ['content' => $contentArray];
            $validationData['content'] = $contentArray;
            $title = ucwords(str_replace("_", " ", $contentArray['type_test']));
        }

        if ($this->validateData($validationData, $validationRules)) {
            $dataCourse = $this->courseModel->select('slug')->where('id', $this->request->getVar('course_id'))->first();
            // dd($dataCourse['slug']);
            $model = new SubcourseModel();

            $data = [
                'course_id' => $this->request->getVar('course_id'),
                'title'     => $title,
                'sequence'  => $this->request->getVar('sequence'),
                'type'      => $type,
            ];
            if ($model->save($data)) {
                $insertedID = $model->insertID();
                if ($type === 'written') {
                    $testModel = new WrittenMaterialModel();
                    $dataMaterial = [
                        'subcourse_id' => $insertedID,
                        'content' => $this->request->getVar('content'),
                    ];
                    $testModel->save($dataMaterial);
                } else if ($type === 'video') {
                    $testModel = new VideoMaterialModel();
                    $dataMaterial = [
                        'subcourse_id' => $insertedID,
                        'video_url' => $this->request->getVar('content'),
                    ];
                    $testModel->save($dataMaterial);
                } else if ($type === 'test') {
                    $testModel = new TestMaterialModel();
                    $optionModel = new OptionTestModel();
                    foreach ($validationData['content']['dataTest'] as $key => $content) {
                        $dataMaterial = [
                            'subcourse_id' => $insertedID,
                            'content' => $content['content'],
                            'sequence' => $content['sequence'],
                            'type_test' => $validationData['content']['type_test'],
                        ];
                        $testModel->save($dataMaterial);
                        $insertedMaterialID = $testModel->insertID();
                        foreach ($content['options'] as $key => $option) {
                            $dataOption = [
                                'test_material_id' => $insertedMaterialID,
                                'answer' => $option['answer'],
                                'correct' => $option['correct'],
                            ];
                            $optionModel->save($dataOption);
                        }
                    }
                }
                $this->session->setFlashdata('msg', 'Berhasil menambahkan subcourse baru');
                return redirect()->to('detail-course/' . $dataCourse['slug']);
            } else {
                $this->session->setFlashdata('msg-failed', 'Gagal menambahkan subcourse baru');
                return redirect()->to('detail-course/' . $dataCourse['slug']);
            }
        } else {
            $validation = $this->validator;
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    // not yet
    public function updateSubCourse($id)
    {
        $validationRules = [
            'title'     => 'required',
            'course_id' => 'required' | 'numeric',
            'sequence'  => 'required' | 'numeric',
            'type' => 'required|in_list[video,test,written]',
            'status'    => 'required|in_list[publish,draft]',
            'content'   => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'The {field} field is required.'
                ],
            ],
        ];
        $validationData = $this->request->getPost();
        // Additional rules based on 'type'
        $type = $this->request->getVar('type');
        if ($type === 'video') {
            $validationRules['content'] = 'required|string';
        } elseif ($type === 'written') {
            $validationRules['content'] = 'required|string';
        } elseif ($type === 'test') {
            /** @var string|null $jsonData */
            $jsonData = $this->request->getPost('content');
            $contentArray = json_decode($jsonData, true);

            // $validationRules['content'] = 'required|array';
            $validationRules['content.sequence'] = 'required|integer';
            $validationRules['content.content'] = 'required|string';
            $validationRules['content.type_test'] = 'required|string';
            $validationRules['content.options'] = 'required|array';
            $validationRules['content.options.*.content'] = 'required|string';
            $validationRules['content.options.*.correct'] = 'required|boolean';
            // $validationData = ['content' => $contentArray];
            $validationData['content'] = $contentArray;
        }

        if ($this->validate($validationData, $validationRules)) {
            $model = new SubcourseModel();

            $data = [
                'course_id' => $this->request->getVar('course_id'),
                'title'     => $this->request->getVar('title'),
                'sequence'  => $this->request->getVar('sequence'),
                'type'      => $this->request->getVar('type'),
                'status'    => $this->request->getVar('status'),
                'updated_at'  => Time::now(),
            ];
            if ($model->update($id, $data)) {
                if ($type === 'written') {
                    $writtenModel = new WrittenMaterialModel();
                    $dataMaterial = [
                        'subcourse_id' => $id,
                        'content' => $this->request->getVar('content'),
                        'updated_at'  => Time::now(),
                    ];
                    $writtenModel->where('subcourse_id', $id)->set($dataMaterial)->update();
                } else if ($type === 'video') {
                    $videoModel = new VideoMaterialModel();
                    $dataMaterial = [
                        'subcourse_id' => $id,
                        'content' => $this->request->getVar('content'),
                        'updated_at'  => Time::now(),
                    ];
                    $videoModel->where('subcourse_id', $id)->set($dataMaterial)->update();
                } else if ($type === 'test') {
                    $testModel = new TestMaterialModel();
                    $optionModel = new OptionTestModel();

                    $material = $testModel->where('subcourse_id', $id)->first();
                    $options = $optionModel->where('test_material_id', $material['id'])->findAll();
                    foreach ($options as $o) {
                        $optionModel->delete($o['id']);
                    }
                    $testModel->delete($material['id']);

                    $dataMaterial = [
                        'subcourse_id' => $id,
                        'content' => $validationData['content']['content'],
                        'sequence' => $validationData['content']['sequence'],
                        'type_test' => $validationData['content']['type_test'],
                        'created_at'  => Time::now(),
                        'updated_at'  => Time::now(),
                    ];

                    $testModel->update($dataMaterial);
                    $insertedMaterialID = $testModel->insertID();
                    foreach ($validationData['content']['options'] as $key => $option) {
                        $dataOption = [
                            'test_material_id' => $insertedMaterialID,
                            'answer' => $option['answer'],
                            'correct' => $option['correct'],
                            'created_at'  => Time::now(),
                            'updated_at'  => Time::now(),
                        ];
                        $optionModel->save($dataOption);
                    }
                }
                return redirect()->to('manage-subcourse');
            } else {

                return redirect()->to('manage-subcourse');
            }
        } else {
            $data['validation'] = $this->validator;
            return view('manage_subcourse', $data);
        }
    }

    // not yet
    public function deleteSubCourse($id)
    {
        $model = new SubcourseModel();
        $modelWritten = new WrittenMaterialModel();
        $modelVideo = new VideoMaterialModel();
        $modelTest = new TestMaterialModel();
        $modelOption = new OptionTestModel();

        $subcourse = $model->find($id);
        $type = $subcourse['type'];

        if ($type === 'written') {
            $material = $modelWritten->where('subcourse_id', $id)->first();
            $modelWritten->delete($material['id']);
        } else if ($type === 'video') {
            $material = $modelVideo->where('subcourse_id', $id)->first();
            $modelVideo->delete($material['id']);
        } else if ($type === 'test') {
            $material = $modelTest->where('subcourse_id', $id)->findAll();
            foreach ($material as $m) {
                $options = $modelOption->where('test_material_id', $m['id'])->findAll();
                foreach ($options as $o) {
                    $modelOption->delete($o['id']);
                }
                $modelTest->delete($m['id']);
            }
        }
    }

    // not yet
    public function updateSubcourseTestSequence() // update urutan soal test material pada subcourse
    {

        // $data=[
        // {
        //     "id"= 1, //id test material
        //     "sequence"= 1
        // },
        // {
        //     "id"= 3, //id test material
        //     "sequence"= 2
        // },
        // {
        //     "id"= 2, //id test material
        //     "sequence"= 3
        // },
        // ];

        /** @var string|null $jsonData */
        $jsonData = $this->request->getPost('testmaterials');
        $contentArray = json_decode($jsonData, true);
        $validationData = ['contentArray' => $contentArray];
        $rules = [
            'contentArray.*.id' => 'required|numeric',
            'contentArray.*.sequence' => 'required|numeric',
        ];

        if ($this->validateData($validationData, $rules)) {
            $model = new TestMaterialModel();
            foreach ($contentArray as $course) {
                $data = [
                    'sequence' => $course['sequence'],
                ];
                $model->update($course['id'], $data);
            }
        }
    }

    // Learning Path | check
    public function createLearningPath()
    {
        $rules = [
            'learning_path_name'            => 'required',
            'learning_path_description'     => 'required',
            'period'                        => 'required|numeric|max_length[3]',
            'learning_path_thumbnail'       => 'uploaded[learning_path_thumbnail]|max_size[learning_path_thumbnail,5120]|is_image[learning_path_thumbnail]|mime_in[learning_path_thumbnail,image/jpg,image/jpeg,image/png]',
        ];

        $slug = url_title($this->request->getVar('learning_path_name'), '-', true);
        if ($this->learningpathModel->where('slug', $slug)->first() != null) {
            $this->session->setFlashdata('msg-failed', 'Judul learning path sudah ada');
            return redirect()->to('manage-course');
        }

        if ($this->validate($rules)) {
            $thumbnail = $this->request->getFile('learning_path_thumbnail');
            $thumbnail->move('images-thumbnail');
            $nameThumbnail = $thumbnail->getName();

            $data = [
                'thumbnail'     => $nameThumbnail,
                'name'          => $this->request->getVar('learning_path_name'),
                'slug'          => $slug,
                'description'   => $this->request->getVar('learning_path_description'),
                'period'        => $this->request->getVar('period'),
                'status'        => 'draft',
                'published_at'  => null,
            ];

            $this->learningpathModel->save($data);
            $this->session->setFlashdata('msg', 'Berhasil menambahkan learning path baru');
            return redirect()->to('detail-learning-path/' . $slug);
        } else {
            $validation = $this->validator;
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    // not yet
    public function updateLearningPath($id)
    {
        $rules = [
            'nama_learning_path'          => 'required',
            'keterangan_learning_path'   => 'required',
            'period'        => 'required|numeric',
            'thumbnail_learning_path'     => 'max_size[thumbnail_learning_path,5120]|is_image[thumbnail_learning_path]|mime_in[thumbnail_learning_path,image/jpg,image/jpeg,image/png]',
        ];

        if ($this->validate($rules)) {
            $model = new LearningPathModel();

            $thumbnail = $this->request->getFile('thumbnail_learning_path');
            //caek gambar lama
            if ($thumbnail->getError() == 4) {
                $nameThumbnail = $this->request->getVar('old_learning_path_thumbnail');
            } else {
                $nameThumbnail = $thumbnail->getRandomName();
                $thumbnail->move('images-thumbnail', $nameThumbnail);
                if ($this->request->getVar('old_learning_path_thumbnail')) {
                    if (file_exists('images-thumbnail/' . $this->request->getVar('old_learning_path_thumbnail'))) {
                        if ($this->request->getVar('old_learning_path_thumbnail') != 'base_thumbnail.jpg') {
                            unlink('images-thumbnail/' . $this->request->getVar('old_learning_path_thumbnail'));
                        }
                    }
                }
            }

            $data = [
                'thumbnail'     => $nameThumbnail,
                'name'          => $this->request->getVar('nama_learning_path'),
                'description'   => $this->request->getVar('keterangan_learning_path'),
                'period'        => $this->request->getVar('period'),
                'updated_at'    => Time::now(),
            ];
            // dd($data);
            if ($this->request->getVar('status') && $this->request->getVar('status') == 'publish') {
                $data['status'] = 'publish';
                $data['published_at'] = Time::now();
            } else {
                $data['published_at'] = null;
            }
            $model->update($id, $data);
            $this->session->setFlashdata('msg', 'Berhasil merubah learning path');
            return redirect()->to('manage-course');
        } else {
            $validation = $this->validator;
            dd($validation->getErrors());
            // return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    // check
    public function deleteLearningPath($id)
    {
        $learningPath = $this->learningpathModel->find($id);
        if ($learningPath == null) {
            $this->session->setFlashdata('msg-failed', 'Learning Path tidak ditemukan');
            return redirect()->back();
        }
        if ($learningPath['thumbnail']) {
            if (file_exists('images-thumbnail/' . $learningPath['thumbnail'])) {
                if ($learningPath['thumbnail'] != 'base_thumbnail.jpg') {
                    unlink('images-thumbnail/' . $learningPath['thumbnail']);
                }
            }
        }

        $this->learningpathModel->delete($id);
        $this->session->setFlashdata('msg', 'Berhasil menghapus Learning Path');
        return redirect()->to('manage-course');
    }

    // not yet
    public function publishLearningPath($id)
    {
        $learningPath = $this->learningpathModel->find($id);
        if ($learningPath == null) {
            $this->session->setFlashdata('msg-failed', 'Learning Path tidak ditemukan');
            return redirect()->back();
        }
        if ($learningPath['status'] == 'publish') {
            $this->session->setFlashdata('msg-failed', 'Learning Path sudah dipublish');
            return redirect()->back();
        }
        $data = [
            'status' => 'publish',
            'published_at' => Time::now(),
        ];
        $this->learningpathModel->update($id, $data);
        return redirect()->to('detail-learning-path/' . $learningPath['slug']);
    }

    public function unpublishLearningPath($id)
    {
        $learningPath = $this->learningpathModel->find($id);
        if ($learningPath == null) {
            $this->session->setFlashdata('msg-failed', 'Learning Path tidak ditemukan');
            return redirect()->back();
        }
        if ($learningPath['status'] != 'publish') {
            $this->session->setFlashdata('msg-failed', 'Learning Path masih belum dipublish');
            return redirect()->back();
        }
        $data = [
            'status' => 'draft',
            'published_at' => null,
        ];
        $this->learningpathModel->update($id, $data);
        return redirect()->to('detail-learning-path/' . $learningPath['slug']);
    }

    // Learning Path Courses | not yet
    public function addCourseToLearningPath($id) //id learning path
    {
        /** @var string|null $jsonData */
        $jsonData = $this->request->getPost('courses');
        $contentArray = json_decode($jsonData, true);
        $validationData = ['contentArray' => $contentArray];
        $rules = [
            'contentArray.*.id' => 'required|numeric',
            'contentArray.*.sequence' => 'required|numeric',
        ];


        if ($this->validate($validationData, $rules)) {
            $learningPathCourseModel = new LearningPathCourseModel();
            foreach ($contentArray as $course) {
                $data = [
                    'learning_path_id' => $id,
                    'course_id' => $course['id'],
                    'sequence' => $course['sequence'],
                    'created_at'  => Time::now(),
                    'updated_at'  => Time::now(),
                ];
                $learningPathCourseModel->save($data);
            }
        }
    }

    // not yet
    public function updateCourseToLearningPath($id) //id learning path
    {
        /** @var string|null $jsonData */
        $jsonData = $this->request->getPost('courses');
        $contentArray = json_decode($jsonData, true);
        $validationData = ['contentArray' => $contentArray];
        $rules = [
            'contentArray.*.id' => 'required|numeric',
            'contentArray.*.sequence' => 'required|numeric',
        ];

        if ($this->validate($validationData, $rules)) {
            $learningPathCourseModel = new LearningPathCourseModel();

            $learningPathCourses = $learningPathCourseModel->where('learning_path_id', $id)->findAll();
            foreach ($learningPathCourses as $learningPathCourse) {
                $learningPathCourseModel->delete($learningPathCourse['id']);
            }

            foreach ($contentArray as $course) {
                $data = [
                    'learning_path_id' => $id,
                    'course_id' => $course['id'],
                    'sequence' => $course['sequence'],
                    'created_at'  => Time::now(),
                    'updated_at'  => Time::now(),
                ];
                $learningPathCourseModel->save($data);
            }
        }
    }

    // not yet
    public function updateSequenceLearningpathCourses() //id learning path
    {
        /** @var string|null $jsonData */
        $jsonData = $this->request->getPost('courses');
        $contentArray = json_decode($jsonData, true);
        $validationData = ['contentArray' => $contentArray];
        $rules = [
            'contentArray.*.id' => 'required|numeric',
            'contentArray.*.sequence' => 'required|numeric',
        ];

        if ($this->validate($validationData, $rules)) {
            $learningPathCourseModel = new LearningPathCourseModel();
            foreach ($contentArray as $course) {
                $data = [
                    'sequence' => $course['sequence'],
                ];
                $learningPathCourseModel->update($course['id'], $data);
            }
        }
    }

    // Assign Learning Path | check
    public function assignLearningPath()
    {
        $userLearningPathModel = new UserLearningPathModel();
        $user_learning_path = $userLearningPathModel->where('user_id', $this->request->getVar('user'))
            ->first();
        if ($user_learning_path != null && $user_learning_path['status'] != 'completed') {
            $this->session->setFlashdata('msg-failed', 'User sedang menjalankan learning path');
            return redirect()->to('manage-assignment-request');
        }
        $userModel = new UsersModel();
        $user = $userModel->where('id', $this->request->getVar('user'))
            ->first();
        if ($user['role_id'] == 1 || $user['role_id'] == 2) {
            $this->session->setFlashdata('msg-failed', 'User tidak dapat diberikan learning path');
            return redirect()->to('manage-assignment-request');
        }
        $rules = [
            'user'                     => 'required',
            'learning_path'            => 'required',
            'message_assignment'       => 'required',
        ];

        if ($this->validate($rules)) {
            $model = new AssignLearningPathModel();
            $userModel = new UsersModel();
            $email = session('email');
            $user = $userModel->where('email', $email)
                ->first();

            $data = [
                'user_id'          => $this->request->getVar('user'),
                'learning_path_id' => $this->request->getVar('learning_path'),
                'admin_id'         => $user['id'],
                'message_assignment' => $this->request->getVar('message_assignment'),
            ];
            $model->save($data);

            // add User Learning Path

            // get data learning path
            $modelLearningPath = new LearningPathModel();
            $learningPath = $modelLearningPath->find($this->request->getVar('learning_path'));

            $data = [
                'user_id' => $this->request->getVar('user'),
                'learning_path_id' => $this->request->getVar('learning_path'),
                'status' => 'not-started',
                'start_date' => Time::now(),
                'end_date' => Time::now()->addMonths($learningPath['period']),
            ];
            $userLearningPathModel->save($data);

            $this->session->setFlashdata('msg', 'Berhasil menambahkan learning path ke user');
            return redirect()->to('manage-assignment-request');
        } else {
            $validation = $this->validator;
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    // User
    // Search User
    public function searchUser($fullname)
    {
        // get id role user
        $modelRole = new RoleModel();
        $role = $modelRole->where('name', 'user')->first();

        $model = new UsersModel();
        $data = $model
        ->where('role_id', $role['id'])
        ->like('fullname', $fullname, 'both')->findAll();
        dd($data);
        return $data;
    }

    // Response Request Learning Path
    public function requestLearningPath($id)
    {
        $rules = [
            'status'           => 'required|in_list[approved,rejected]'
        ];

        if ($this->validate($rules)) {
            $model = new RequestLearningPathModel();

            $data = [
                'status'           => $this->request->getVar('status'),
                'admin_id'         => session('id'),
                'responded_at'  => Time::now(),
            ];
            $model->update($id, $data);

            // add User Learning Path
            if ($this->request->getVar('status') == 'approved') {
                $request = $model->find($id);
                // get data learning path
                $modelLearningPath = new LearningPathModel();
                $learningPath = $modelLearningPath->find($request['learning_path_id']);

                $userLearningPathModel = new UserLearningPathModel();
                $data = [
                    'user_id' => $request['user_id'],
                    'learning_path_id' => $request['learning_path_id'],
                    'status' => 'not-started',
                    'start_date' => Time::now(),
                    'end_date' => Time::now()->addMonths($learningPath['period']),
                ];
                $userLearningPathModel->save($data);
            }
            $this->session->setFlashdata('msg', 'Berhasil merespon request learning path');
            return redirect()->back();
        } else {
            $validation = $this->validator;
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    // Category
    public function createCategory()
    {
        $rules = [
            'name'          => 'required',
        ];

        if ($this->validate($rules)) {
            $model = new CategoryModel();

            $data = [
                'name'          => $this->request->getVar('name'),
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ];
            $model->save($data);
            return redirect()->to('manage-category');
        } else {
            $data['validation'] = $this->validator;
            return view('manage-category', $data);
        }
    }

    public function updateCategory($id)
    {
        $rules = [
            'name'          => 'required',
        ];

        if ($this->validate($rules)) {
            $model = new CategoryModel();

            $data = [
                'name'          => $this->request->getVar('name'),
                'updated_at'    => Time::now(),
            ];
            $model->update($id, $data);
            return redirect()->to('manage-category');
        } else {
            $data['validation'] = $this->validator;
            return view('manage-category', $data);
        }
    }

    public function deleteCategory($id)
    {
        $model = new CategoryModel();

        $model->delete($id);
        return redirect()->to('manage-category');
    }

    // News

    public function createNews()
    {
        $rules = [
            'title'          => 'required',
            'content'        => 'required',
            'category_id'    => 'required|numeric',
            'thumbnail_news'      => 'uploaded[thumbnail_news]|max_size[thumbnail_news,5120]|is_image[thumbnail_news]|mime_in[thumbnail_news,image/jpg,image/jpeg,image/png]',
        ];

        $slug = url_title($this->request->getVar('title'), '-', true);
        if ($this->validate($rules)) {
            $thumbnail = $this->request->getFile('thumbnail_news');
            $thumbnail->move('images-thumbnail');
            $nameThumbnail = $thumbnail->getName();

            $data = [
                'thumbnail'     => $nameThumbnail,
                'title'          => $this->request->getVar('title'),
                'slug'          => $slug,
                'content'        => $this->request->getVar('content'),
                'category_id'    => $this->request->getVar('category_id'),
                'admin_id'       => session('id'),
                'status'         => 'draft',
                'published_at'  => null,
            ];

            $this->newsModel->save($data);
            $this->session->setFlashdata('msg', 'Berhasil menambahkan news baru');
            return redirect()->to('manage-news');
        } else {
            $validation = $this->validator;
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    }

    public function updateNews($id)
    {
        $rules = [
            'title'          => 'required',
            'content'        => 'required',
            'thumbnail'      => 'max_size[thumbnail,5120]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]',
            'status'         => 'required|in_list[publish,draft]',
        ];

        if ($this->validate($rules)) {
            $model = new NewsModel();

            $thumbnail = $this->request->getFile('thumbnail');
            //caek gambar lama
            if ($thumbnail->getError() == 4) {
                $nameThumbnail = $this->request->getVar('oldThumbnail');
            } else {
                $nameThumbnail = $thumbnail->getRandomName();
                $thumbnail->move('thumbnailNews', $nameThumbnail);
                unlink('thumbnailNews/' . $this->request->getVar('oldThumbnail'));
            }

            $data = [
                'thumbnail'     => $nameThumbnail,
                'title'          => $this->request->getVar('title'),
                'content'        => $this->request->getVar('content'),
                'status'         => $this->request->getVar('status'),
                'updated_at'    => Time::now(),
            ];
            if ($this->request->getVar('status') == 'publish') {
                $data['published_at'] = Time::now();
            } else {
                $data['published_at'] = null;
            }
            $model->update($id, $data);
            return redirect()->to('manage-news');
        } else {
            $data['validation'] = $this->validator;
            return view('manage-news', $data);
        }
    }

    public function deleteNews($id)
    {
        $model = new NewsModel();

        $thumbnail = $model->find($id);
        unlink('thumbnailNews/' . $thumbnail['thumbnail']);

        $model->delete($id);
        return redirect()->to('manage-news');
    }

    public function publishNews($id)
    {
        $model = new NewsModel();
        $dataNews = $model->find($id);
        if ($dataNews == null) {
            $this->session->setFlashdata('msg-failed', 'News tidak ditemukan');
            return redirect()->back();
        }
        if ($dataNews['status'] == 'publish') {
            $this->session->setFlashdata('msg-failed', 'News sudah dipublish');
            return redirect()->back();
        }
        $data = [
            'status' => 'publish',
            'published_at' => Time::now(),
        ];
        $model->update($id, $data);
        return redirect()->to('detail-news/' . $dataNews['slug']);
    }

    public function unpublishNews($id)
    {
        $model = new NewsModel();
        $dataNews = $model->find($id);
        if ($dataNews == null) {
            $this->session->setFlashdata('msg-failed', 'News tidak ditemukan');
            return redirect()->back();
        }
        if ($dataNews['status'] != 'publish') {
            $this->session->setFlashdata('msg-failed', 'News masih belum dipublish');
            return redirect()->back();
        }
        $data = [
            'status' => 'draft',
            'published_at' => null,
        ];
        $model->update($id, $data);
        return redirect()->to('detail-news/' . $dataNews['slug']);
    }

    // Upload Image for content wriiten materials
    public function uploadImage()
    {
        $file = $this->request->getFile('file');
        $name = $file->getRandomName();
        $file->move('images', $name);
        return $this->response->setJSON(['location' => base_url('images/' . $name)]);
    }
}
