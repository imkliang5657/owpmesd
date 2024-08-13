<?php

class AnnouncementController extends Controller
{
    private mixed $announcementModel;
    private mixed $announcementFileModel;

    public function __construct() {
        $this->announcementModel = $this->model('Announcement');
        $this->announcementFileModel = $this->model('AnnouncementFile');
    }

    public function search() {
        $getData = $this->retrieveGetData();
        $keyWord = empty($getData['keyWord']) ? NULL : $getData['keyWord'];
        $organization = empty($getData['organization']) ? NULL : $getData['organization'];
        $startDateTime = empty($getData['startDate']) ? NULL : $getData['startDate'] . ' 00:00:00';
        $endDateTime = empty($getData['endDate']) ? NULL : $getData['endDate'] . ' 23:59:59';
        $announcements = $this->announcementModel->retrieveByCondition($keyWord, $organization, $startDateTime, $endDateTime);
        $organizations = $this->announcementModel->retrieveAllOrganization();
        $this->view('announcement/search', ['organizations' => $organizations, 'announcements' => $announcements]);
    }

    public function retrieve() {
        $getData = $this->retrieveGetData();
        $announcement = $this->announcementModel->retrieveById($getData['id']);
        $files = $this->announcementFileModel->retreiveByAnnouncementId($announcement['id']);
        $this->view('announcement/retrieve', ['announcement' => $announcement, 'files' => $files]);
    }

    public function modify() {
        $getData = $this->retrieveGetData();
        $success = empty($getData['success']) ? 0 : 1;
        $announcement = $this->announcementModel->retrieveById($getData['id']);
        $files = $this->announcementFileModel->retreiveByAnnouncementId($announcement['id']);
        $this->view('announcement/modify', ['announcement' => $announcement, 'files' => $files, 'success' => $success]);
    }

    public function update() {
        $getData = $this->retrieveGetData();
        $postData = $this->retrievePostData();
        $this->announcementModel->update(
            $getData['id'], $postData['title'],
            $postData['content'], $postData['is_link'],
            $postData['organization']);
        $this->redirect('./?url=page/announcements/announcement/modify&id='.$getData['id'].'&success=1');
    }

    public function delete() {
        $getData = $this->retrieveGetData();
        $this->announcementModel->delete($getData['id']);
        $this->redirect('./?url=page/announcements');
    }

    public function add() {
        $this->view('announcement/add');
    }

    public function create() {
        $postData = $this->retrievePostData();
        $this->announcementModel->create($postData['title'], $postData['content'], $postData['is_link'], $postData['organization']);
        $this->redirect('./?url=page/announcements');
    }
}