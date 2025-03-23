<?php
require_once 'admin/config/article.php';

$article = new Article();
$articles = $article->getArticles();
?>
    <section id="latest-blog" class="py-5 my-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<div class="section-header align-center">
						<div class="title">
							<span>Read our articles</span>
						</div>
						<h2 class="section-title">Latest Articles</h2>
					</div>

					<div class="row">					
					<?php foreach ($articles as $row): ?>
						<div class="col-md-4">

							<article class="column" data-aos="fade-up">

								<figure>
								<a href="#" class="image-hvr-effect">
									<img src="admin/<?php echo $row['image']; ?>" alt="post" class="post-image">
								</a>
								</figure>

								<div class="post-item">
									<div class="meta-date"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></div>
									<h3><a href="#"><?php echo htmlspecialchars($row['title']); ?></a></h3>

									<div class="links-element">
										<div class="categories"><?php echo htmlspecialchars($row['category']); ?></div>
										<div class="social-links">
											<ul>
												<li>
													<a href="#"><i class="icon icon-facebook"></i></a>
												</li>
												<li>
													<a href="#"><i class="icon icon-twitter"></i></a>
												</li>
												<li>
													<a href="#"><i class="icon icon-behance-square"></i></a>
												</li>
											</ul>
										</div>
									</div><!--links-element-->

								</div>
							</article>

						</div>
					<?php endforeach; ?>	
					</div>

					<div class="row">

						<div class="btn-wrap align-center">
							<a href="#" class="btn btn-outline-accent btn-accent-arrow" tabindex="0">Read All Articles<i
									class="icon icon-ns-arrow-right"></i></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

    