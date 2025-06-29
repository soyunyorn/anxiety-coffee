<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php 
	if(isset($_GET['id'])) {
		$id = $_GET['id'];

		//data for single product
		$product = $conn->query("SELECT * FROM products WHERE id='$id'");
		$product->execute();

		$singelProduct = $product->fetch(PDO::FETCH_OBJ);
		
		//data for relatedProducts
		$relatedProducts = $conn->query("SELECT * FROM products WHERE type='$singelProduct->type'
		AND id !='$singelProduct->id'");

		$relatedProducts->execute();

		$allRelatedProducts = $relatedProducts->fetchAll(PDO::FETCH_OBJ);

		//add to cart
		if(isset($_POST['submit'])) {

			$name = $_POST['name'];
			$image = $_POST['image'];
			$price = $_POST['price'];
			$pro_id = $_POST['pro_id'];
			$description = $_POST['description'];
			$quantity = $_POST['quantity'];
			$user_id = $_SESSION['user_id'];

			$insert_cart = $conn->prepare("INSERT INTO cart (name, image, price, pro_id, description,
			quantity, user_id) VALUES (:name, :image, :price, :pro_id, :description, :quantity, :user_id)");

			$insert_cart->execute([
				":name" => $name,
				":image" => $image,
				":price" => $price,
				":pro_id" => $pro_id,
				":description" => $description,
				":quantity" => $quantity,
				":user_id" => $user_id
			]);

			echo "<script>alert('added to cart successfully');</script>";
		}

		///validation for the cart
		if(isset($_SESSION['user_id'])) {
			$validateCart = $conn->query("SELECT * FROM cart WHERE pro_id='$id' AND
			user_id='$_SESSION[user_id]'");
			$validateCart->execute();

			$rowCount = $validateCart->rowCount();
		}
		
	} else {
		header("location: ".APPURL."/404.php");
	}
?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const minusBtn = document.querySelector('.quantity-left-minus');
    const plusBtn = document.querySelector('.quantity-right-plus');
    const quantityInput = document.getElementById('quantity');

    minusBtn.addEventListener('click', function (e) {
      e.preventDefault();
      let quantity = parseInt(quantityInput.value);
      if (quantity > 1) {
        quantityInput.value = quantity - 1;
      }
    });

    plusBtn.addEventListener('click', function (e) {
      e.preventDefault();
      let quantity = parseInt(quantityInput.value);
      quantityInput.value = quantity + 1;
    });
  });
</script>

<section class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-5 ftco-animate">
				<a href="h-50 images/menu-2.jpg" class="image-popup">
					<img src="<?php echo IMAGEPRODUCTS; ?>/<?php echo $singelProduct->image; ?>" class="img-fluid" alt="Colorlib Template">
				</a>
			</div>
			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
				<h3><?php echo $singelProduct->name; ?></h3>
				<p class="price"><span>$<?php echo $singelProduct->price; ?></span></p>
				<p><?php echo $singelProduct->description; ?></p>
				
				<form method="POST" action="product-single.php?id=<?php echo $id; ?>">

					<div class="row mt-4">
						<div class="col-md-6">
							<!-- Example select dropdown you commented out can go here -->
						</div>
						<div class="w-100"></div>
						<div class="input-group col-md-6 d-flex mb-3">
							<span class="input-group-btn mr-2">
								<button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
									<i class="icon-minus"></i>
								</button>
							</span>

							<input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
							
							<span class="input-group-btn ml-2">
								<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
									<i class="icon-plus"></i>
								</button>
							</span>
						</div>
					</div>

					<input name="name" value="<?php echo $singelProduct->name; ?>" type="hidden">
					<input name="image" value="<?php echo $singelProduct->image; ?>" type="hidden">
					<input name="price" value="<?php echo $singelProduct->price; ?>" type="hidden">
					<input name="pro_id" value="<?php echo $singelProduct->id; ?>" type="hidden">
					<input name="description" value="<?php echo $singelProduct->description; ?>" type="hidden">

					<div class="mt-4">
						<?php if(isset($_SESSION['user_id'])) : ?>
                        <?php if($rowCount > 0) : ?>
                        <button name="submit" type="submit" class="btn btn-primary btn-outline-primary" disabled>Added to Cart</button>
                        <?php else : ?>  
                        <button name="submit" type="submit" class="btn btn-primary btn-outline-primary">Add to Cart</button>
                      <?php endif; ?>  
						<?php else : ?>
					  
                       <p>Login to add product to cart</p>
                        <?php endif; ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-3">
			<div class="col-md-7 heading-section ftco-animate text-center">
				<span class="subheading">Discover</span>
				<h2 class="mb-4">Related products</h2>
				<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
			</div>
		</div>
		<div class="row">
			<?php foreach($allRelatedProducts as $allRelatedProduct) : ?>
			<div class="col-md-3">
				<div class="menu-entry">
					<a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $allRelatedProduct->id; ?>" class="img" style="background-image: url(<?php echo IMAGEPRODUCTS; ?>/<?php echo $allRelatedProduct->image; ?>);"></a>
					<div class="text text-center pt-4">
						<h3><a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $allRelatedProduct->id; ?>"><?php echo $allRelatedProduct->name; ?></a></h3>
						<p><?php echo $allRelatedProduct->description; ?></p>
						<p class="price"><span>$<?php echo $allRelatedProduct->price; ?></span></p>
						<p><a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $allRelatedProduct->id; ?>" class="btn btn-primary btn-outline-primary">show</a></p>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<style>
/* Match your site's button hover color */
.btn-outline-primary:hover,
.btn-outline-primary:focus {
  color: #fff !important;
  background-color:rgb(110, 85, 11) !important; /* replace with your actual color */
  border-color:rgb(110, 85, 11) !important;
}

/* Optional: keep disabled buttons in the same style */
.btn-outline-primary:disabled,
.btn-outline-primary:disabled:hover {
  color: #fff !important;
  background-color:rgb(110, 85, 11)7 !important;
  border-color:rgb(110, 85, 11) !important;
  opacity: 1;
}
</style>


<?php require "../includes/footer.php"; ?>
