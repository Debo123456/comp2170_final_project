

  <body>
    
    <?php
    	//process login form if submitted
    	if(isset($_POST['submit'])){
      
      
        //Login validation
        $validate = new Validate();
        			$validation = $validate->check(array(
        				'username' => array(
                  'required' => true
                ),
        				'password' => array(
                  'required' => true
                )
        			));
    
        			if($validation->passed()) { //If login credentials exists.
        				//log user in
                $user = $this->model('User');
                
        				$login = $user->login(Input::get('username'), Input::get('password')); //Log user in. See User->login() function.
        				if($login)
        				{
        					header('Location: ../public/Main'); //If login was succesful redirect to index page.;
        				}
        				else {
                    $message = 'username or password invalid'; //If login was unsuccesful store error message in $message variable.
        				}
        			}
        			else {
                  $message = 'Username and password is required';// if validation failed store error message in $message variable.
        				}
        			}//end if submit
    
    	if(isset($message)){ echo $message; }
    	
    	?>

  	<div class="container login-container">

    		<div class="login">
    		  <h1> Inventory management system</h1>
    		  <br />
    		  <form action='' method='post' class="form-horizontal">
            <div class="form-group">
              <label for="username" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="username" placeholder="Username" name='username'>
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" placeholder="Password" name='password'>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Remember me
                  </label>
                </div>
              </div>
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" >
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name='submit'>Sign in</button>
              </div>
            </div>
          </form>
    		</div>

    		<?php
          //$model->get('blog_posts');//Retreives all data from Users table

            //Print Blog info retreived from database
           /* foreach ($model->data() as $results) {
    					echo '<div>';
    					echo '<h1><a href="'.str_replace(' ', '_', $results['postTitle']).'">'.$results['postTitle'].'</a></h1>';
    				  echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($results['postDate'])).'</p>';
    					echo '<p>'.$results['postDesc'].'</p>';
    					echo '<p><a href="'.str_replace(' ', '_', $results['postTitle']).'">Read More</a></p>';
    					echo '</div>';
    				}*/
    		?>

  	</div>


  </body>
