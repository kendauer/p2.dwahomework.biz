<?php

class posts_controller extends base_controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        # Make sure user is logged in if they want to use anything in this controller
        if (!$this->user) {
            die("Members only. <a href='/users/login'>Login</a>");
        }
    }
    
    public function index($confirmation)
    {
        
        # Set up the View 
        $this->template->content = View::instance('v_posts_index');
        #Pass along the confirmation
        $this->template->content->confirmation = $confirmation;
        #Give the page a title
        $this->template->title   = "All Posts";
        
        # Query to show the posts of the users the logged in user is following
        $q = 'SELECT 
    		posts.post_id,
            posts.content,
            posts.created,
            posts.user_id AS post_user_id,
            users_users.user_id AS follower_id,
            users.first_name,
            users.last_name
        FROM posts
        INNER JOIN users_users 
            ON posts.user_id = users_users.user_id_followed
        INNER JOIN users 
            ON posts.user_id = users.user_id
        WHERE users_users.user_id = ' . $this->user->user_id;
        
        # Run the query, store the results in the variable $posts
        $posts = DB::instance(DB_NAME)->select_rows($q);
        
        #query for the like status of the posts
        $q = 'SELECT users_posts.post_id AS liked_id
                FROM users_posts 
                INNER JOIN posts 
                    ON posts.post_id = users_posts.post_id
                WHERE users_posts.user_id = ' . $this->user->user_id;
        
        # assigned the results of the above query to $like
        $like = DB::instance(DB_NAME)->select_array($q, 'liked_id');
        
        #pass the posts and their like status to the template
        $this->template->content->posts = $posts;
        $this->template->content->like  = $like;
        
        # Render the View
        echo $this->template;
        
    }
    
    public function add()
    {
        
        # Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title   = "New Post";
        
        # Render template
        echo $this->template;
        
    }
    
    public function p_add()
    { 
        # basic sanitization of post data...
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        
        # Associate this post with this user
        $_POST['user_id'] = $this->user->user_id;
        
        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();
        
        # Insert the post date to the database
        DB::instance(DB_NAME)->insert('posts', $_POST);
        
        # Send them to the posts list where they can view their new post
        Router::redirect("/posts/index/confirmation");
        
    }
    
    public function users()
    {
        # Set up the View and assign the title
        $this->template->content = View::instance("v_posts_users");
        $this->template->title   = "Users";
        
        # Build the query to get all the users
        $q = "SELECT *
        FROM users";
        
        # Execute the query to get all the users. 
        # Store the result array in the variable $users
        $users = DB::instance(DB_NAME)->select_rows($q);
        
        # Build the query to figure out what connections does this user already have? 
        # I.e. who are they following
        $q = "SELECT * 
        FROM users_users
        WHERE user_id = " . $this->user->user_id;
        
        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id_followed" field as the index.
        # This will come in handy when we get to the view
        # Store our results (an array) in the variable $connections
        $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
        
        # Pass data (users and connections) to the view
        $this->template->content->users       = $users;
        $this->template->content->connections = $connections;
        
        # Render the view
        echo $this->template;
    }
    
    public function follow($user_id_followed)
    { 
        # Prepare the data array to be inserted
        $data = Array(
            "created" => Time::now(),
            "user_id" => $this->user->user_id,
            "user_id_followed" => $user_id_followed
        );
        
        # Do the insert
        DB::instance(DB_NAME)->insert('users_users', $data);
        
        # Send them back
        Router::redirect("/posts/users");   
    }
    
    public function unfollow($user_id_followed)
    { 
        # Delete this connection
        $where_condition = 'WHERE user_id = ' . $this->user->user_id . ' AND user_id_followed = ' . $user_id_followed;
        DB::instance(DB_NAME)->delete('users_users', $where_condition);
        
        # Send them back
        Router::redirect("/posts/users"); 
    }
    
    public function like($post_id)
    {
        # Prepare the data array to be inserted, capturing the user_id of the logged in user and the liked post_id
        $data = Array(
            "user_id" => $this->user->user_id,
            "post_id" => $post_id
        );
        
        # Do the insert/like the post
        DB::instance(DB_NAME)->insert('users_posts', $data);
        
        # Send them back
        Router::redirect("/posts");
        
    }
    
    public function unlike($post_id)
    {
        # Delete this connection/unlike the post
        $where_condition = 'WHERE user_id = ' . $this->user->user_id . ' AND post_id = ' . $post_id;
        DB::instance(DB_NAME)->delete('users_posts', $where_condition);
        
        # Send them back to the posts index
        Router::redirect("/posts");
    }  
}
# end of the class