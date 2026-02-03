<?php
require_once __DIR__ . '/../models/Forum.php';

class ForumController {
    public function index(){
        $topics = Forum::all();
        require __DIR__ . '/../views/forums/list.php';
    }
    public function view(){
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) { echo 'Topic not found'; return; }
        $topic = Forum::find($id);
        if (!$topic) { echo 'Topic not found'; return; }
        // Fetch replies for display
        $replies = Forum::replies($id);
        require __DIR__ . '/../views/forums/view.php';
    }
}
