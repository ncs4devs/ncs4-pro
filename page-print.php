<?php

function parse_query() {
  $src = $_GET['src'];
  $industries = explode(",", $_GET['industries']);
  $topics = explode(",", $_GET['topics']);

  return [$src, $industries, $topics];
}

function get_elements_by_classname($xpath, $class) {
  return $xpath -> query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");
}

function element_to_string($element) {
  if (empty($element)) {
    return;
  }
  return $element -> ownerDocument -> saveHTML($element);
}

function get_subtopic($dom, $id) {
  return $dom -> getElementById("ncs4-bp-subtopic__" . $id);
}

function get_subtopics($dom, $ids) {
  $out = [
    get_subtopic($dom, "0")
  ];
  foreach ($ids as $id) {
    array_push($out, get_subtopic($dom, $id));
  }
  return $out;
}

function remove_element($element) {
  $element -> parentNode -> removeChild($element);
}

// Returns true if the page is a valid BP Topic page, false otherwise
function is_authorized_page($dom, $xpath, $src) {
  $post_status = get_post_status($src);

  // Is published
  if (!$post_status || $post_status !== "publish") {
    return false;
  }

  // Contains exactly one bp-content block
  if (count(get_elements_by_classname(
      $xpath,
      "wp-block-ncs4-custom-blocks-bp-content"
    )) !== 1) {
    return false;
  }

  return true;
}

function filter_elements($elements, $industries) {
  $exceptions = [
    "wp-block-ncs4-custom-blocks-generic-section",
  ];

  foreach ($elements as $e) {
    $classes = explode(" ", $e -> getAttribute("class"));
    $include = false;

    foreach ($industries as $slug) {
      if (
           in_array("ncs4-bp-content__" . $slug, $classes)
        || count(array_intersect($exceptions, $classes)) > 0
      ) {
        $include = true;
        break;
      }
    }
    if (in_array("ncs4-best-practices-instructions", $classes)) {
      $include = false;
    }
    if (!$include) {
      remove_element($e);
    }
  }
}

// Remove industry content if it isn't selected
function filter_industries($dom, $xpath, $industries) {
  filter_elements(
    get_elements_by_classname($xpath, "ncs4-section"),
    $industries
  );
  filter_elements(
    get_elements_by_classname($xpath, "ncs4-custom-blocks-mixed-section-beam"),
    $industries
  );
}

function generate_content() {
  [$src, $industries, $topics] = parse_query();

  if (empty($src)) {
    http_response_code(400); // Bad request
    return;
  }

  $post = get_post($src);

  if (empty($post)) {
    http_response_code(400); // Bad Request
    return;
  }

  $dom = new DOMDocument();
  @$dom -> loadHTML("<?xml encoding='utf-8'?>" .
    apply_filters("the_content", $post -> post_content)); // Suppress HTML5 warnings
  $xpath = new DomXPath($dom);

  if (!is_authorized_page($dom, $xpath, $src)) {
    http_response_code(403); // Forbidden
    return;
  }

  filter_industries($dom, $xpath, $industries);

  foreach (get_subtopics($dom, $topics) as $topic) {
    echo element_to_string($topic);
  }
}

function load_styles() {
  do_action("wp_enqueue_scripts");
  print_admin_styles();
}

function create_header() {
  echo '
  <div class="print-page-header">
    ' . file_get_contents(get_stylesheet_directory() . "/img/logo-dark.svg") . '
    <img src="' . get_stylesheet_directory_uri() . '/img/landmark-logo-small.png" style="margin-left: 40px; width: 100px; height: 100px;">
    <p>Best Practices</p>
    <hr>
  </div>';
}



?>

<!doctype html>
<html <?php language_attributes(); ?>>
<?php include('template-parts/message.html');?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Best Practices - Print</title>
	<link rel="profile" href="https://gmpg.org/xfn/11">
  <?php load_styles() ?>
  <style><?php include get_stylesheet_directory() . '/page-print.css'; ?></style>
</head>

<body <?php body_class(); ?>>

<?php

create_header();
generate_content();

?>
</body>
</html>
