<div class="mp_wrapper">
  <h3 class="mpca-fat-bottom"><?php printf(__('Corporate account for %s', 'memberpress-corporate'), $owner_name); ?></h3>

  <div id="mpca_sub_accounts_used" class="mpca-fat-bottom">
    <h4><?php printf(__('%1$s of %2$s Sub Accounts Used', 'memberpress-corporate'), $ca->num_sub_accounts_used(), $ca->num_sub_accounts); ?></h4>
  </div>

  <?php MeprView::render('/shared/errors', compact('errors','message')); ?>

  <div id="mpca-add-sub-user" class="mpca-fat-bottom">

    <?php
      $sub_welcome_checked = isset($_POST['action']) ? isset($_POST['userdata[welcome]']) : false;
      $manage_sub_accounts_form = isset($_POST['manage_sub_accounts_form']) ? isset($_POST['manage_sub_accounts_form']) : false;
      $mpca_class = 'mpca-hidden';
      $form_data = array(
        'user_login'  =>  '',
        'user_email'  =>  '',
        'first_name'  =>  '',
        'last_name'  =>  '',
      );
      if($manage_sub_accounts_form == 'add' && !empty($errors)){
        $mpca_class = '';
        if(isset($_POST['userdata'])){
          if(is_array($_POST['userdata'])){
            $form_data['user_login'] = isset($_POST['userdata']['user_login']) ? $_POST['userdata']['user_login'] : '';
            $form_data['user_email'] = isset($_POST['userdata']['user_email']) ? $_POST['userdata']['user_email'] : '';
            $form_data['first_name'] = isset($_POST['userdata']['first_name']) ? $_POST['userdata']['first_name'] : '';
            $form_data['last_name'] = isset($_POST['userdata']['last_name']) ? $_POST['userdata']['last_name'] : '';
            $form_data = wp_unslash($form_data);
          }
        }
      }
    ?>

    <?php if($ca->num_sub_accounts > $ca->num_sub_accounts_used()): ?>
    <button id="mpca-add-sub-user-btn" class="mpca-fat-bottom" type="button" value=""><?php _e('Add Sub Account', 'memberpress-corporate') ?></button>
    <?php endif ?>

    <form action="" method="post" id="mpca-add-sub-user-form" class="<?php echo $mpca_class; ?>">
      <input type="hidden" name="action" value="manage_sub_accounts" />
      <input type="hidden" name="manage_sub_accounts_form" value="add" />
      <input type="hidden" name="mepr_product_id" value="<?php echo esc_attr($product_id); ?>" />
      <label>
        <span><?php _e('Existing Username', 'memberpress-corporate'); ?> </span>
      </label>
      <?php if(MeprUtils::is_mepr_admin()): ?>
        <input value="" type="text" name="userdata[existing_login]" class="mepr_suggest_user" placeholder="<?php _e('Begin Typing Name', 'memberpress', 'memberpress-corporate') ?>" />
      <?php else: ?>
        <input value="" type="text" name="userdata[existing_login]" />
      <?php endif ?>
      <?php MeprHooks::do_action('mepr-user-signup-fields'); ?>

      <input class="mpca-fat-top" type="submit" value="<?php _e('Submit', 'memberpress-corporate') ?>" />
    </form>
  </div>

  <div class="mpca-search mpca-fat-bottom">
    <input
      id="mpca_sub_account_search"
      type="text" placeholder="<?php _e('Search Sub Accounts...', 'memberpress-corporate'); ?>"
      value="<?php echo $search; ?>" />
  </div>

  <?php if(!empty($sub_accounts)): ?>
    <?php $alt = false; ?>
    <div class="mpca-sub-account-page-info">
      <?php printf(__('Page %1$s of %2$s (%3$s Sub Accounts)', 'memberpress-corporate'), $currpage, $total_pages, $total_sub_accounts); ?>
    </div>
    <div class="mpca-table-overflow">
      <table id="mpca-sub-accounts-table" class="mepr-account-table">
        <thead>
          <tr>
            <th><?php _ex('Username', 'ui', 'memberpress-corporate'); ?></th>
            <th><?php _ex('Email', 'ui', 'memberpress-corporate'); ?></th>
            <th><?php _ex('First Name', 'ui', 'memberpress-corporate'); ?></th>
            <th><?php _ex('Last Name', 'ui', 'memberpress-corporate'); ?></th>
            <th><?php _ex('Last Login', 'ui', 'memberpress-corporate'); ?></th>
            <th><?php _ex('Logins', 'ui', 'memberpress-corporate'); ?></th>
            <th> </th>
            <?php do_action('mpca-sub-accounts-th', $mepr_current_user, $sub_accounts); ?>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach($sub_accounts as $sa):
            $user = new MeprUser($sa->ID);
            $last_login = $user->get_last_login_data();
            ?>
            <tr id="mpca-sub-accounts-row-<?php echo $sa->ID; ?>" class="mpca-sub-accounts-row <?php echo (isset($alt) && !$alt)?'mepr-alt-row':''; ?>">
              <td><?php echo $sa->user_login; ?></td>
              <td><?php echo $sa->user_email; ?></td>
              <td><?php echo $sa->first_name; ?></td>
              <td><?php echo $sa->last_name; ?></td>
              <td><?php echo $last_login ? MeprAppHelper::format_date($last_login->created_at, 'Never') : __('Never', 'memberpress-corporate'); ?></td>
              <td><?php echo $user->login_count; ?></td>
              <td><a href="" data-ca="<?php echo $ca->id; ?>" data-sa="<?php echo $sa->ID; ?>" class="mpca-remove-sub-account"><?php _e('Remove', 'memberpress-corporate'); ?></a> <?php do_action('mpca-sub-accounts-links', $mepr_current_user, $ca, $sa); ?></td>
              <?php do_action('mpca-sub-accounts-td', $mepr_current_user, $sa); ?>
            </tr>
            <?php $alt = !$alt; ?>
          <?php endforeach; ?>
          <?php do_action('mpca-sub-accounts-table', $mepr_current_user, $sub_accounts); ?>
        </tbody>
      </table>
    </div>
    <br/>
    <div id="mepr-sub-account-paging">
      <?php $sub_account_search = !empty($search) ? "&search={$search}" : ''; ?>
      <?php if($prev_page): ?>
        <a href="<?php echo "{$account_url}{$delim}action=manage_sub_accounts&ca={$ca->uuid}&currpage={$prev_page}{$sub_account_search}"; ?>">&lt;&lt; <?php _ex('Previous Page', 'ui', 'memberpress-corporate'); ?></a>
      <?php endif; ?>
      <?php if($next_page): ?>
        <a href="<?php echo "{$account_url}{$delim}action=manage_sub_accounts&ca={$ca->uuid}&currpage={$next_page}{$sub_account_search}"; ?>" style="float:right;"><?php _ex('Next Page', 'ui', 'memberpress-corporate'); ?> &gt;&gt;</a>
      <?php endif; ?>
    </div>
    <div style="clear:both">&nbsp;</div>
    <?php
  else:
    _ex('You have no sub accounts to display.', 'ui', 'memberpress-corporate');
  endif;
  ?>
  <div id="mpca_export_sub_accounts" class="mpca-fat-bottom">
    <a href="<?php echo $ca->export_url(); ?>"><?php _e('Export Sub Accounts', 'memberpress-corporate');?></a>
  </div>



  <?php if($ca->num_sub_accounts > $ca->num_sub_accounts_used() && defined('MPCA_IMPORTERS_PATH') === true): ?>
  
  <?php endif ?>
  <?php do_action('mpca-restrictions'); ?>
</div>
