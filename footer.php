<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * Requires the WordPress plugin "Simple Social Icons"
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NCS4_Pro
 */

 function hasPosts($category) {
	 $posts = get_posts([
		 'numberposts'		=> 1,
		 'category'				=> get_cat_ID( $category ),
		 'post_type'			=> 'post',
	 ]);
	 return !empty($posts);
 }

 function createPostsList($category, $maxPosts = -1) {
	 $posts = get_posts([
		 'numberposts'		=> $maxPosts,
		 'category'				=> get_cat_ID( $category ),
		 'orderby'				=> 'date',
		 'post_type'			=> 'post',
	 ]);

	 foreach ( $posts as $post ) {
		 echo
		 	'<li>
		 		<a href="'. get_permalink( $post ) . '">
					'. $post -> post_title .'
				</a>
			</li>';
	 }
 }

 function createArchiveLink($category) {
	 echo '
	 	<a class="ncs4-archive-link" href="'. get_category_link(get_cat_ID($category)) .'">
			View All
		</a>';
 }

 function createSocialIcon($name, $url) {
   $n = strtolower($name);
   echo '
    <a href="'. $url .'" target="_blank" rel="noopener noreferrer" class="ssi-'.
      $n .'" title="'. $name .'">
      <svg class="social-'. $n .'" role="img" aria-labelledby="social-'.
        $n .'-2" viewbox="0 0 32 32">
        <title id="social-'. $n .'-2">'. $name .'</title>
        <use xlink:href="/wp-content/plugins/simple-social-icons/symbol-defs.svg#social-'.
        $n .'"></use>
      </svg>
    </a>
   ';
 }

?>

	<footer id="colophon" class="site-footer">
		<div id="footer-widget-area">
			<div id="footer-widget-area__inner" class="ncs4-site-margin no-padding">
				<div class="widget-area widget-area__1">
					<img
            src="<?= get_template_directory_uri() . '/img/footer.jpg'?>"
            <?= getimagesize(get_template_directory() . '/img/footer.jpg')[3] ?>
          >
					<section class="widget-text-area contact-info">
						<h4>Mailing Address</h4>
						<p>
							The National Center for Spectator Sports Safety and Security<br>
							The University of Southern Mississippi<br>
							118 College Drive #5193 | Hattiesburg, MS 39406
						</p>
						<h4>Physical Address</h4>
						<p>6197 Highway 49 | Hattiesburg, MS 39401</p>
						<h4 class="no-caps">Phone: <a href="tel:6012666183">601-266-6183</a></h4>
						<h4 class="no-caps">Email: <a href="mailto:ncs4@usm.edu">ncs4@usm.edu</a></h4>
					</section><!-- .widget-text-area.contact-info -->
				</div><!-- .widget-area__1 -->
				<div class="widget-area widget-area__2">
					<section class="widget-text-area recent-posts">

						<?php if ( hasPosts('News') ) { ?>
							<section class="post-area post-area__news">
								<h4>In The News</h4>
								<ul id="news-list" class="ncs4-posts-list">
									<?php createPostsList('News', 5) ?>
								</ul><!-- #news-list -->
								<?php createArchiveLink('News') ?>
							</section><!-- .post-area__news -->
						<?php } ?>

						<?php if ( hasPosts('Events') ) { ?>
							<section class="post-area post-area__events">
								<h4>Upcoming Events</h4>
								<ul id="events-list" class="ncs4-posts-list">
									<?php createPostsList('Events') ?>
								</ul><!-- #events-list -->
								<?php createArchiveLink('Events') ?>
							</section><!-- .post-area__events -->
						<?php } ?>

						<?php if ( hasPosts('Uncategorized') ) { ?>
							<section class="post-area post-area__uncategorized">
								<h4>Recent Posts</h4>
								<ul id="uncategorized-list" class="ncs4-posts-list">
									<?php createPostsList('Uncategorized', 5) ?>
								</ul><!-- #uncategorized-list -->
								<?php createArchiveLink('Uncategorized') ?>
							</section><!-- .post-area__uncategorized -->
						<?php } ?>

					</section><!-- .widget-text-area.recent-posts -->
				</div><!-- .widget-area__2 -->
				<div class="widget-area widget-area__3">
          <div class="widget-text-area quick-links">
            <section class="quick-links--directory">
              <h4>Quick Links</h4>
              <p class="links">
                <a href="/about/">About NCS⁴</a><br>
                <a href="/training/dhs-fema-courses">DHS/FEMA Training</a><br>
                <a href="https://ncs4demo.usm.edu/redirect?url=https://ncs4.learnworlds.com/home">
                  E-Learning</a><br>
                <a href="/training/cssp/">CSSP Certification</a><br>
                <a href="/resources/best-practices/">
                  Best Practices</a><br>
                <a href="/membership/">Become a Member</a><br>
                <a href="/resources/newsletter/">
                  Subscribe to Newsletter</a><br>
                <a href="/industry-engagement/sponsorship-opportunities/">
                  Advertise and Sponsor</a><br>
                <a href="/about/contact-us/">Contact Us</a>
                <br>
                <br>
                Privacy Policy (Coming soon!)
              </p><!-- .links -->
            </section><!-- .quick-links--directory -->
            <section class="quick-links--social-media">
              <?php
                createSocialIcon("Facebook", "https://www.facebook.com/usmncs4");
                createSocialIcon("LinkedIn", "https://www.linkedin.com/in/ncs4usm");
                createSocialIcon("Twitter", "https://twitter.com/ncs4usm");
                createSocialIcon("YouTube", "https://www.youtube.com/channel/UCUvonlCDvCxaoWw7IpO1Hiw");
              ?>
            </section><!-- .quick-links--social-media -->
          </div><!-- .quick-links -->
				</div><!-- .widget-area__3 -->
			</div><!-- #footer-widget-area__inner -->
		</div><!-- #footer-widget-area -->
		<div id="footer-copyright-area">
			<div id="footer-copyright-area__inner" class="ncs4-site-margin no-padding">
				<p id="footer-copyright">© 2021 The National Center for Spectator Sports Safety and Security. All rights reserved.</p>
			</div><!-- #footer-copyright-area__inner -->
		</div><!-- #footer-copyright-area -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
<?php include('template-parts/credits.html');?>
</html>
