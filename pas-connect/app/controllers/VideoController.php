<?php
require_once __DIR__ . '/../models/Video.php';

class VideoController {
    public function index(){
        $videos = Video::all();
        require __DIR__ . '/../views/videos/list.php';
    }
    public function view(){
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) { echo 'Video not found'; return; }
        $video = Video::find($id);
        if (!$video) { echo 'Video not found'; return; }
        require __DIR__ . '/../views/videos/view.php';
    }
}
