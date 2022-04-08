<?php
  $url = htmlspecialchars($_GET["url"]);
  $isValid = filter_var($url, FILTER_VALIDATE_URL);
  if ($isValid) {
    header("refresh: 1; url=" . $url);
  }
?>
<?php get_header(); ?>
  <main
    id="primary"
    class="site-main site-main__redirect"
  >
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="entry-content entry-content__front-page">
        <div
          class="ncs4-site-margin ncs4-site-margin__size-small wp-block-ncs4-custom-blocks-margin"
          style="
            padding-top: 3rem;
            padding-bottom: 3rem;
            margin-top: 3rem;
            margin-bottom: 3rem;
          "
        >
          <?php
            if ($isValid) {
              echo "<p>Please wait while you are redirected. If the new page does not load, click <a href='"
                . $url . "' target='_blank'>here</a></p>";
            } else {
              echo "<p>Something went wrong. Please try again later. (<code class='error'>Err: Invalid url</code>)</p>";
            }
          ?>
        </div><!-- .ncs4-site-margin -->
      </div><!-- .entry-content -->
    </article><!-- #post-<?php the_ID(); ?> -->
  </main><!-- .site-main -->

<?php get_footer(); ?>
