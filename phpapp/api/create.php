<?php
if( !isset($_SERVER ['PHP_AUTH_USER']))
{
    header ("WWW-Authenticate: Basic realn=\"Private Area\"");
    header ("HHTP/1.0 4001 Unauthorized");
    print "Sorry, you need proper credentials";
    exit;
}else
{
    if (($_SERVER['PHP_AUTH_USER'] == 'bill' && ($_SERVER['PHP_AUTH_PW'] == '1234')))
    {
        //headers
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

        //initializing our api
        include_once('../core/initialize.php');

        //instantiate post

        $post = new Post($db);

        //get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        $post->title = $data->title;
        $post->body = $data->body;
        $post->author = $data->author;
        $post->category_id = $data->category_id;

        //create post
        if($post->create()){
            echo json_encode(
                array('message' => 'Post created.')
            );
        }else{
            echo json_encode(
                array('message' => 'Post not created.')
            );
        }

    }else
    {
        header ("WWW-Authenticate: Basic realn=\"Private Area\"");
        header ("HHTP/1.0 4001 Unauthorized");
        print "Sorry, you need proper credentials";
    }
}

