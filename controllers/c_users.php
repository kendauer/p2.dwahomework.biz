<?php
class users_controller extends base_controller
{
    /*-------------------------------------------------------------------------------------------------
    
    -------------------------------------------------------------------------------------------------*/
    public function __construct()
    {
        # Make sure the base controller construct gets called
        parent::__construct();
    }
    
    
    /*-------------------------------------------------------------------------------------------------
    Display a form so users can sign up	
    -------------------------------------------------------------------------------------------------*/
    public function signup($error = NULL)
    {
        # Set up the view
        $this->template->content        = View::instance('v_users_signup');
        # Pass data to the view if there was an error generated
        $this->template->content->error = $error;
        # Render the view
        echo $this->template;
    }
    
    
    /*-------------------------------------------------------------------------------------------------
    Process the sign up form
    -------------------------------------------------------------------------------------------------*/
    public function p_signup()
    {
        
        # basic sanitization of post data...
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        
        # query the database to see if the email used to sign up already exists in the db.
        $q           = "SELECT * FROM users WHERE email = '" . $_POST['email'] . "'";
        $user_exists = DB::instance(DB_NAME)->select_rows($q);
        
        # if the email address has already been used, send them to the homepage page. 
        if (!empty($user_exists)) {
            Router::redirect("/users/signup/user-exists");
        }
        
        #if any fields are blank, throw an error message.
		elseif(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['password']) || empty($_POST['email']))
        {
        Router::redirect("/users/signup/blank-fields"); 
        }
        
        #if the email address has not been used, create a new account. Plus one feature, send them an email to notify them
        else {
            
            # Mark the time the account was created
            $_POST['created'] = Time::now();
            
            # Hash password using sha1 and then salt it with PASSWORD_SALT
            $_POST['password'] = sha1(PASSWORD_SALT . $_POST['password']);
            
            # Create a hashed token using sha1 and TOKEN_SALT
            $_POST['token'] = sha1(TOKEN_SALT . $_POST['email'] . Utils::generate_random_string());
            
            # Insert the new user into the database   
            DB::instance(DB_NAME)->insert_row('users', $_POST);
            
            #lastly, send the user an email letting them know they created an account.
            $to      = $_POST['email'];
            $subject = "Squeak Registration";
            $message = "Your new account has successfully been created.";
            $from    = 'kennethdauer@dwahomework.biz';
            $headers = "From:" . $from;
            
            if (!$this->user) {
                mail($to, $subject, $message, $headers);
            }
            
        }
        
        # and finally throw them back to the login page
        Router::redirect('/users/login');    
    }
    
    
    /*-------------------------------------------------------------------------------------------------
    Display a form so users can login. Calls the v_users_login view.
    -------------------------------------------------------------------------------------------------*/
    public function login($error = NULL)
    {
        # Set up the view
        $this->template->content = View::instance("v_users_login");
        
        # Pass data to the view, $error will trigger an error message on the view.
        $this->template->content->error = $error;
        
        # Render the view
        echo $this->template;
    }
    
    
    /*-------------------------------------------------------------------------------------------------
    Process the login form
    -------------------------------------------------------------------------------------------------*/
    public function p_login()
    { 
        # Hash the password they entered so we can compare it with the ones in the database
        $_POST['password'] = sha1(PASSWORD_SALT . $_POST['password']);
        
        # Set up the query to see if there's a matching email/password in the DB
        $q = 'SELECT token 
			FROM users
			WHERE email = "' . $_POST['email'] . '"
			AND password = "' . $_POST['password'] . '"';
        ;
        
        # If there was, this will return the token	   
        $token = DB::instance(DB_NAME)->select_field($q);
        
        # Success
        if ($token) {
            
            # Don't echo anything to the page before setting this cookie!
            setcookie('token', $token, strtotime('+1 year'), '/');
            
            # Send them to the homepage
            Router::redirect('/');
        }
        # Fail
        else {
            Router::redirect("/users/login/error");
        } 
    }
    
    
    /*-------------------------------------------------------------------------------------------------
    No view needed here, they just goto /users/logout, it logs them out and sends them
    back to the homepage.	
    -------------------------------------------------------------------------------------------------*/
    public function logout()
    { 
        # Generate a new token they'll use next time they login
        $new_token = sha1(TOKEN_SALT . $this->user->email . Utils::generate_random_string());
        
        # Update their row in the DB with the new token
        $data = Array(
            'token' => $new_token
        );
        DB::instance(DB_NAME)->update('users', $data, 'WHERE user_id =' . $this->user->user_id);
        
        # Delete their old token cookie by expiring it
        setcookie('token', '', strtotime('-1 year'), '/');
        
        # Send them back to the homepage
        Router::redirect('/');
    }
    
    /*-------------------------------------------------------------------------------------------------
    
    -------------------------------------------------------------------------------------------------*/
    public function profile($user_name = NULL)
    {  
        # Only logged in users are allowed, sends all others to index where they can sign up or log in
        if (!$this->user) {
            Router::redirect('/');
        }
    
        # Set up the View
        $this->template->content = View::instance('v_users_profile');
        $this->template->title   = $this->user->user_id . "'s Profile";
        
        # Pass username and the user's posts to the view
        $q                                  = 'SELECT * FROM posts WHERE user_id = ' . $this->user->user_id;
        $this->template->content->user_name = $user_name;
        $posts                              = DB::instance(DB_NAME)->select_rows($q);
        $this->template->content->posts     = $posts;
        
        # Display the view
        echo $this->template;     
    }   
} # end of the class