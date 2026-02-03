<?php
require_once __DIR__ . '/../models/Community.php';

class CommunityController {
    public function index(){
        $posts = Community::all();
        require __DIR__ . '/../views/community/list.php';
    }
    public function view(){
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) { echo 'Post not found'; return; }
        $post = Community::find($id);
        if (!$post) { echo 'Post not found'; return; }
        require __DIR__ . '/../views/community/view.php';
    }
}
