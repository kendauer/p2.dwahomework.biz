<?php

class index_controller extends base_controller
{
    
    /*-------------------------------------------------------------------------------------------------
    
    -------------------------------------------------------------------------------------------------*/
    public function __construct()
    {
        parent::__construct();
    }
    
    /*-------------------------------------------------------------------------------------------------
    Accessed via http://localhost/index/index/
    -------------------------------------------------------------------------------------------------*/
    public function index()
    {
        
        # Any method that loads a view will commonly start with this
        # First, set the content of the template with a view file
        $this->template->content = View::instance('v_index_index');
        
        # Now set the default <title> tag
        $this->template->title = "Squeak";
        
        #create a query that will pull all the posts from users the user is following
        if ($this->user) {
            
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
            
            #create a query for the liked status of each post
            $q = 'SELECT users_posts.post_id AS liked_id
                FROM users_posts 
                INNER JOIN posts 
                    ON posts.post_id = users_posts.post_id
                WHERE users_posts.user_id = ' . $this->user->user_id;
            
            $like = DB::instance(DB_NAME)->select_array($q, 'liked_id');
            
            #pass the template the posts and the like status
            $this->template->content->posts = $posts;
            $this->template->content->like  = $like;
        }
        
        # Render the view
        echo $this->template;
        
    } # End of method
     
} # End of class