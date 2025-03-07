<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'admin/config/db.php';
require_once 'admin/config/cart.php';

$cart = new Cart();
$cartCount = $cart->getCartCount(session_id());
?>
<!--header-wrap-->
<div id="header-wrap">
		<div class="top-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<div class="social-links">
							<ul>
								<li>
									<a href="#"><i class="icon icon-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="icon icon-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="icon icon-youtube-play"></i></a>
								</li>
								<li>
									<a href="#"><i class="icon icon-behance-square"></i></a>
								</li>
							</ul>
						</div><!--social-links-->
					</div>
					<div class="col-md-6">
						<div class="right-element">
						<div class="action-menu">
							<div class="search-bar">
								<a href="" class="search-button search-toggle" data-selector="#header-wrap">
									<i class="icon icon-search"></i>
								</a>
								<form role="search" method="get" class="search-box">
									<input class="search-field text search-input" placeholder="Search"
										type="search">
								</form>
							</div>
							</div>
							<a href="index.php?f=account" class="user-account for-buy"><i
									class="icon icon-user"></i><span>Account</span>

							</a>
							<a href="index.php?f=cart" class="for-buy">
								<i class="icon icon-clipboard"></i>
								Cart: <span id="cart-count">(<?= $cartCount ?>)</span></a>
						</div><!--top-right-->
					</div>
				</div>
			</div>
		</div>
		<div><!--top-content-->

		<header id="header">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-2">
						<div class="main-logo" >
							<a href="index.php"><img src="images/book logo.png"  alt="logo"></a>
						</div>
					</div>
					<div class="col-md-10">
						<nav id="navbar">
							<div class="main-menu stellarnav" >
								<ul class="menu-list"style="margin-left: 180px;">
									<li class="menu-item active"><a href="index.php">Home</a></li>
									<li class="menu-item has-sub">
										<a href="#pages" class="nav-link">Pages</a>

										<ul>											
											<li><a href="index.php?f=popular-books">Popular</a></li>	
											<li><a href="index.php?f=special-offer">Offer</a></li>											
											<li><a href="index.php?f=download-app">Download App</a></li>										
											<li><a href="index.php?f=blog">Articles</a></li>
											<li><a href="index.php?f=thankyou">Thank You</a></li>
										</ul>

									</li>
									<li class="menu-item"><a href="index.php?f=store" class="nav-link">Our Store</a></li>
									<li class="menu-item"><a href="index.php?f=about" class="nav-link">About</a></li>
									<li class="menu-item"><a href="index.php?f=contact" class="nav-link">Contact</a></li>
									<li class="menu-item"><a href="index.php?f=blog" class="nav-link">Blog</a></li>
								</ul>

								<div class="hamburger">
									<span class="bar"></span>
									<span class="bar"></span>
									<span class="bar"></span>
								</div>

							</div>
						</nav>

					</div>

				</div>
			</div>
		</header>

	</div>