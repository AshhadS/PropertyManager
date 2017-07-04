<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>IDSS Login</title>
  
  
  
  <link rel="stylesheet" href="{{ asset('/css/login.css') }}" rel="stylesheet" type="text/css" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>

<body>
  <div class="body"></div>
		<div class="grad"></div>
			<div class="form">
			      
			      <!-- <ul class="tab-group">
			        <li class="tab active"><a href="#signup">Sign Up</a></li>
			        <li class="tab active"><a href="#login">Log In</a></li>
			      </ul> -->
			      
			          <!-- 
			      <div class="tab-content">
			        <div id="signup">   
			          <h1>Property Management</h1>
			          <p>Registration has been closed please contact site admin</p>
			          
			          <form action="/register" method="post">
			           {{-- csrf_field() --}}
			          <div class="top-row">
			            <div class="field-wrap">
			              <label>
			                First Name<span class="req">*</span>
			              </label>
			              <input type="text" name='fname' required autocomplete="off" />
			            </div>
			        
			            <div class="field-wrap">
			              <label>
			                Last Name<span class="req">*</span>
			              </label>
			              <input type="text" name='fname' required autocomplete="off"/>
			            </div>
			          </div>

			          <div class="field-wrap">
			            <label>
			              Email Address<span class="req">*</span>
			            </label>
			            <input type="email" name='email' required autocomplete="off"/>
			          </div>
			          
			          <div class="field-wrap">
			            <label>
			              Set A Password<span class="req">*</span>
			            </label>
			            <input type="password" name='password' required autocomplete="off"/>
			          </div>
			          
			          <button type="submit" class="button button-block"/>Register</button>
			          
			          </form> 

			        </div>
			          -->
			        
			        <div id="login">   
			          <h1>Welcome Back!</h1>
			          
			          <form action="/login" method="post">
				          {{ csrf_field() }}
			          
			            <div class="field-wrap">
			            <label>
			              Email Address<span class="req">*</span>
			            </label>
			            <input type="email" name="email" required />
			          </div>
			          
			          <div class="field-wrap">
			            <label>
			              Password<span class="req">*</span>
			            </label>
			            <input type="password" name="password" required />
			          </div>
			          		          
			          <button class="button button-block"/>Login</button>
			          
			          </form>

			        </div>
			        
			      </div><!-- tab-content -->
			      
			</div> <!-- /form -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>
	// $('.form').find('input, textarea').on('keyup blur focus', function (e) {
	  
	//   var $this = $(this),
	//       label = $this.prev('label');

	// 	  if (e.type === 'keyup') {
	// 			if ($this.val() === '') {
	//           label.removeClass('active highlight');
	//         } else {
	//           label.addClass('active highlight');
	//         }
	//     } else if (e.type === 'blur') {
	//     	if( $this.val() === '' ) {
	//     		label.removeClass('active highlight'); 
	// 			} else {
	// 		    label.removeClass('highlight');   
	// 			}   
	//     } else if (e.type === 'focus') {
	      
	//       if( $this.val() === '' ) {
	//     		label.removeClass('highlight'); 
	// 			} 
	//       else if( $this.val() !== '' ) {
	// 		    label.addClass('highlight');
	// 			}
	//     }

	// });

	// $('.tab a').on('click', function (e) {
	  
	//   e.preventDefault();
	  
	//   $(this).parent().addClass('active');
	//   $(this).parent().siblings().removeClass('active');
	  
	//   target = $(this).attr('href');

	//   $('.tab-content > div').not(target).hide();
	  
	//   $(target).fadeIn(600);
	  
	// });
</script>
  
</body>
</html>
