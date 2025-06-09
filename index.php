<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 

	$products = $conn->query("SELECT * FROM products WHERE type='drink'");
	$products->execute();

	$allProducts = $products->fetchAll(PDO::FETCH_OBJ);


	$reviews = $conn->query("SELECT * FROM reviews");
	$reviews->execute();

	$allReviews = $reviews->fetchAll(PDO::FETCH_OBJ);

?>

    <section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image: url(images/bg_1.jpg);">
       <div class="overlay"></div>
       <div class="container">
         <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
           <div class="col-md-8 col-sm-12 text-center ftco-animate">
             <span class="subheading">Welcome</span>
             <h1 class="mb-4">The Best Coffee Testing Experience</h1>
             <p class="mb-4 mb-md-5">Like the gentle flow of the Tonle Sap and Mekong rivers through Phnom Penh, our coffee brings you calm and comfort in every cup. Close to home, crafted for your peaceful moments.</p>
             <p>
               <a href="<?php echo isset($_SESSION['user_id']) ? 'users/Orders.php' : 'auth/login.php'; ?>" 
                  class="btn btn-primary p-3 px-xl-4 py-xl-3">
                  Order Now
               </a> 
     
               <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">
                  View Menu
               </a>
             </p>
           </div>
     
         </div>
       </div>
     </div>

      <div class="slider-item" style="background-image: url(images/bg_2.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
           <div class="col-md-8 col-sm-12 text-center ftco-animate">
             <span class="subheading">Welcome</span>
             <h1 class="mb-4">Amazing Taste &amp; Beautiful Place</h1>
              <p class="mb-4 mb-md-5">Like the gentle flow of the Tonle Sap and Mekong rivers through Phnom Penh, our coffee brings you calm and comfort in every cup. Close to home, crafted for your peaceful moments.</p>
             <p>
               <a href="<?php echo isset($_SESSION['user_id']) ? 'users/Orders.php' : 'auth/login.php'; ?>" 
                  class="btn btn-primary p-3 px-xl-4 py-xl-3">
                  Order Now
               </a> 
     
               <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">
                  View Menu
               </a>
             </p>
           </div>
     
         </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url(images/bg_3.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
           <div class="col-md-8 col-sm-12 text-center ftco-animate">
             <span class="subheading">Welcome</span>
             <h1 class="mb-4">Creamy Hot and Ready to Serve</h1>
              <p class="mb-4 mb-md-5">Like the gentle flow of the Tonle Sap and Mekong rivers through Phnom Penh, our coffee brings you calm and comfort in every cup. Close to home, crafted for your peaceful moments.</p>
             <p>
               <a href="<?php echo isset($_SESSION['user_id']) ? 'users/Orders.php' : 'auth/login.php'; ?>" 
                  class="btn btn-primary p-3 px-xl-4 py-xl-3">
                  Order Now
               </a> 
     
               <a href="menu.php" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">
                  View Menu
               </a>
             </p>
           </div>
     
         </div>
        </div>
      </div>
    </section>

    <section class="ftco-intro">
    	<div class="container-wrap">
    		<div class="wrap d-md-flex align-items-xl-end">
	    		<div class="info">
	    			<div class="row no-gutters">
	    				<div class="col-md-4 d-flex ftco-animate">
	    					<div class="icon"><span class="icon-phone"></span></div>
	    					<div class="text">
	    						<h3>+855 966 685 018</h3>
	    						<p>A gentle flow of support is always nearby, we’re here to keep things smooth and steady.</p>
	    					</div>
	    				</div>
	    				<div class="col-md-4 d-flex ftco-animate">
	    					<div class="icon"><span class="icon-my_location"></span></div>
	    					<div class="text">
	    						<h3> West 21th Street</h3>
	    						<p>	168st Phnom Penh Tmey, Sen Sok, Phnom Penh</p>
	    					</div>
	    				</div>
	    				<div class="col-md-4 d-flex ftco-animate">
	    					<div class="icon"><span class="icon-clock-o"></span></div>
	    					<div class="text">
	    						<h3>Open Monday-Friday</h3>
	    						<p>7:00am - 9:00pm</p>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    		<div class="book p-4">
	    			<h3>Book a Table</h3>
	    			<form action="booking/book.php" method="POST" class="appointment-form">
	    				<div class="d-md-flex">
		    				<div class="form-group">
		    					<input type="text" name="first_name" class="form-control" placeholder="First Name">
		    				</div>
		    				<div class="form-group ml-md-4">
		    					<input type="text" name="last_name" class="form-control" placeholder="Last Name">
		    				</div>
	    				</div>
	    				<div class="d-md-flex">
		    				<div class="form-group">
		    					<div class="input-wrap">
		            		<div class="icon"><span class="ion-md-calendar"></span></div>
		            		<input name="date" type="text" class="form-control appointment_date" placeholder="Date">
	            		</div>
		    				</div>
		    				<div class="form-group ml-md-4">
		    					<div class="input-wrap">
		            		<div class="icon"><span class="ion-ios-clock"></span></div>
		            		<input name="time" type="text" class="form-control appointment_time" placeholder="Time">
	            		</div>
		    				</div>
		    				<div class="form-group ml-md-4">
		    					<input name="phone" type="text" class="form-control" placeholder="Phone">
		    				</div>
	    				</div>
	    				<div class="d-md-flex">
	    					<div class="form-group">
		              <textarea name="message" id="" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
		            </div>
					<?php if(isset($_SESSION['user_id'])) : ?>
						<div class="form-group ml-md-4">
							<button type="submit" name="submit" class="btn btn-white py-3 px-4">Book a Table</button>
						</div>
					<?php else : ?>
						<p class="text-white">login to book a table</p>	
					<?php endif; ?>
	    				</div>
	    			</form>
	    		</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-about d-md-flex">
    	<div class="one-half img" style="background-image: url(images/about.jpg);"></div>
    	<div class="one-half ftco-animate">
    		<div class="overlap">
	        <div class="heading-section ftco-animate ">
	        	<span class="subheading">Discover</span>
	          <h2 class="mb-4">Our Story</h2>
	        </div>
	        <div>
	  				<p>At Anxiety Coffee, we believe coffee is more than a drink — it’s a ritual, a comfort, a connection.
                       Born from a love for bold brews and cozy spaces, we created a place where creativity flows as freely as our espresso.
                       Whether you’re fueling up for the day or winding down with friends, our doors are open and the coffee is always strong.
                       Come for the caffeine, stay for the calm.</p>
	  			</div>
  			</div>
    	</div>
    </section>

    <section class="ftco-section ftco-services">
    	<div class="container">
    		<div class="row">
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-choices"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Easy to Order</h3>
                <p>We’ve made ordering as smooth as your first sip. No complicated steps, no overwhelming choices — just a quick, calming way to get the coffee you love, delivered right when you need it.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-delivery-truck"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Fastest Delivery</h3>
                <p>Your coffee, on your terms — fast, fresh, and right when you need it. Because anxiety doesn’t wait, and neither should you.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-coffee-bean"></span></div>
              <div class="media-body">
                <h3 class="heading">Quality Coffee</h3>
                <p>We believe great coffee shouldn't just wake you up — it should ease you in. That’s why we source premium beans, roast them with precision,
                  and brew every cup to bring comfort, not chaos. No bitter aftertaste, no caffeine jitters — just a smooth, grounded experience that helps you face the day, one peaceful sip at a time.</p>
              </div>
            </div>    
          </div>
        </div>
    	</div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row align-items-center">
    			<div class="col-md-6 pr-md-5">
    				<div class="heading-section text-md-right ftco-animate">
	          	<span class="subheading">Discover</span>
	            <h2 class="mb-4">Our Menu</h2>
	            <p class="mb-4">From the first sip to the final drop, every cup at Anxiety Coffee tells a story. Handcrafted with passion, sourced from the finest beans, and brewed to perfection — our menu is a journey through bold flavors,
					 rich aromas, and comforting warmth. Come discover what makes every visit unforgettable.</p>
	            <p><a href="menu.php" class="btn btn-primary btn-outline-primary px-4 py-3">View Full Menu</a></p>
	          </div>
    			</div>
    			<div class="col-md-6">
    				<div class="row">
    					<div class="col-md-6">
    						<div class="menu-entry">
		    					<a href="#" class="img" style="background-image: url(images/menu-1.jpg);"></a>
		    				</div>
    					</div>
    					<div class="col-md-6">
    						<div class="menu-entry mt-lg-4">
		    					<a href="#" class="img" style="background-image: url(images/menu-2.jpg);"></a>
		    				</div>
    					</div>
    					<div class="col-md-6">
    						<div class="menu-entry">
		    					<a href="#" class="img" style="background-image: url(images/menu-3.jpg);"></a>
		    				</div>
    					</div>
    					<div class="col-md-6">
    						<div class="menu-entry mt-lg-4">
		    					<a href="#" class="img" style="background-image: url(images/menu-4.jpg);"></a>
		    				</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-counter ftco-bg-dark img" id="section-counter" style="background-image: url(images/bg_2.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
      <div class="container">
        <div class="row justify-content-center">
        	<div class="col-md-10">
        		<div class="row">
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="100">0</strong>
		              	<span>Coffee Branches</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="85">0</strong>
		              	<span>Number of Awards</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="10567">0</strong>
		              	<span>Happy Customer</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="900">0</strong>
		              	<span>Staff</span>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
          	<span class="subheading">Discover</span>
            <h2 class="mb-4">Best Coffee Sellers</h2>
            <p>Explore the favorites that keep our customers coming back. From bold espresso shots to smooth, creamy blends — these are the brews that have earned a special place in every coffee lover’s heart. Crafted with care, served with passion.</p>
          </div>
        </div>
        <div class="row">
			<?php foreach($allProducts as $prodcut) : ?>
				<div class="col-md-3">
					<div class="menu-entry">
							<a target="_blank" href="products/product-single.php?id=<?php echo $prodcut->id; ?>" class="img" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $prodcut->image; ?>);"></a>
							<div class="text text-center pt-4">
								<h3><a href="#"><?php echo $prodcut->name; ?></a></h3>
								<p><?php echo $prodcut->description; ?></p>
								<p class="price"><span>$<?php echo $prodcut->price; ?></span></p>
								<p><a target="_blank" href="products/product-single.php?id=<?php echo $prodcut->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
							</div>
						</div>

				</div>
			<?php endforeach; ?>
        	
        </div>
    	</div>
    </section>

    <!--<section class="ftco-gallery">
    	<div class="container-wrap">
    		<div class="row no-gutters">
					<div class="col-md-3 ftco-animate">
						<a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-1.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-3.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-3.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="gallery.html" class="gallery img d-flex align-items-center" style="background-image: url(images/gallery-4.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
        </div>
    	</div>
    </section>-->

    

    <section class="ftco-section img" id="ftco-testimony" style="background-image: url(images/bg_1.jpg);"  data-stellar-background-ratio="0.5">
    	<div class="overlay"></div>
	    <div class="container">
	      <div class="row justify-content-center mb-5">
	        <div class="col-md-7 heading-section text-center ftco-animate">
	        	<span class="subheading">Testimony</span>
	          <h2 class="mb-4">Customers Says</h2>
	          <p>Far away from the noise of the world, Anxiety-Coffee feels like a peaceful escape. It’s my daily calm behind the chaos — simple, soothing, and always reliable.</p>
	        </div>
	      </div>
	    </div>
	    <div class="container-wrap">
	      <div class="row d-flex no-gutters">
			<?php foreach($allReviews as $review) : ?>
	        <div class="col-md-3 align-self-sm-end ftco-animate">
	          <div class="testimony">
	             <blockquote>
	                <p>&ldquo;<?php echo $review->review; ?>.&rdquo;</p>
	              </blockquote>
	              <div class="author d-flex mt-4">
	              
	                <div class="name align-self-center"><?php echo $review->username; ?></div>
	              </div>
	          </div>
	        </div>
			<?php endforeach;  ?>
	       
	      </div>
	    </div>
	  </section>
<?php require "includes/footer.php"; ?>   
