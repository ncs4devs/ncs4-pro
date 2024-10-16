<?php
$url = htmlspecialchars($_GET["url"]);
$isValid = filter_var($url, FILTER_VALIDATE_URL);
$validDomains = ['ncs4.usm.edu', 'usm.edu', 'cvent.me', 'web.cvent.com', 'ncs4.learnworlds.com'];

function getDomain($url)
{
  $host = parse_url($url, PHP_URL_HOST); // Get the host part of the URL
  return $host ? $host : false;
}

$urlDomain = getDomain($url);
$isDomainValid = $urlDomain && in_array($urlDomain, $validDomains);

if ($isValid && $isDomainValid) {
  header("refresh: 1; url=" . $url);
}
?>

<?php get_header(); ?>
<main id="primary" class="site-main site-main__redirect">
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
      <div
        class="ncs4-site-margin ncs4-site-margin__size-small wp-block-ncs4-custom-blocks-margin"
        style="padding-top: 3rem; padding-bottom: 3rem; margin-top: 3rem; margin-bottom: 3rem;">

        <?php
        if ($isValid && $isDomainValid) {
          echo "<p>Please wait while you are redirected. If the new page does not load, click <a href='"
            . $url . "' target='_blank'>here</a>.</p>";
        } elseif (!$isValid) {
          header("HTTP/1.1 400 Bad Request");
          echo "<p>Something went wrong. Please try again later. (<code class='error'>Err: Invalid URL format</code>)</p>";
          exit;
        } elseif (!$isDomainValid) {
          header("HTTP/1.1 403 Forbidden");
          echo "<p>The URL provided is not from a valid domain. Please use a valid domain (<code class='error'>Err: Invalid domain</code>).</p>";
          exit;
        }
        ?>

      </div><!-- .ncs4-site-margin -->
    </div><!-- .entry-content -->
  </article><!-- #post-<?php the_ID(); ?> -->
</main><!-- .site-main -->

<?php get_footer(); ?>