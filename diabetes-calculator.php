<?php
/**
 * Plugin Name:       Diabetes Calculator
 * Plugin URI:        https://github.com/interdevel/diabetes-calculator/
 * Description:       A WordPress plugin to help with diabetes care.
 * Version:           0.0.1
 * Requires at least: 5.3
 * Tested up to:      6.7 
 * Requires PHP:      7.4
 * Author:            Luis Molina
 * Author URI:        https://github.com/interdevel
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       diabetes-calculator
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
  exit;
}

define( 'DTCALC_VERSION', '0.0.1' );
define( 'DTCALC_PLUGIN', __FILE__ );
define( 'DTCALC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'DTCALC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

$dtcalc_resources_list = array(
  array(
    'name' => 'ISPAD (International Society for Pediatric and Adolescent Diabetes) 2022 Clinical Practice Consensus Guidelines.',
    'link' => 'https://cdn.ymaws.com/www.ispad.org/resource/resmgr/consensus_guidelines_2018_/guidelines2022/Ch_10_Pediatric_Diabetes_-_2.pdf',
    'lang' => 'English',
  ),
  array(
    'name' => 'Efficacy of insulin dosing algorithms for high-fat high-protein mixed meals to control postprandial glycemic excursions in people living with type 1 diabetes: A systematic review and meta-analysis.',
    'link' => 'https://doi.org/10.1111/pedi.13436',
    'lang' => 'English',
  ),
  array(
    'name' => 'Las grasas y las proteínas también cuentan',
    'link' => 'https://diabetes.sjdhospitalbarcelona.org/es/diabetes-tipo-1/consejos/grasas-proteinas-tambien-cuentan',
    'lang' => 'Español',
  ),
  array(
    'name' => 'Grasas, proteínas y su efecto en las glucemias',
    'link' => 'https://diabetesmadrid.org/grasas-proteinas-y-su-efecto-en-las-glucemias/',
    'lang' => 'Español',
  )
);



// Add menu items in admin panel
function dtcalc_loader_menu()
{
  add_options_page(
    __('Diabetes Calculator', 'diabetes-calculator'),
    __('Diabetes Calculator', 'diabetes-calculator'),
    'manage_options',
    'dtcalc_loader',
    'dtcalc_loader_page'
  );
  add_management_page(
    __('Diabetes Calculator', 'diabetes-calculator'),
    __('Diabetes Calculator', 'diabetes-calculator'),
    'manage_options',
    'dtcalc_loader',
    'dtcalc_tools_page'
  );
}
add_action('admin_menu', 'dtcalc_loader_menu');

// Display plugin settings page
function dtcalc_loader_page()
{
  ?>
  <div class="wrap">
    <h2><?php esc_html_e('Diabetes Calculator Settings', 'diabetes-calculator') ?></h2>
    <form method="post" action="options.php">
      <?php settings_fields('dtcalc_loader_options'); ?>
      <?php do_settings_sections('dtcalc_loader_options'); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row"><?php esc_html_e('Test option: ', 'diabetes-calculator') ?></th>
          <td><input type="text" name="dtcalc_id" value="<?php echo esc_attr(get_option('dtcalc_test_option')); ?>" />
          </td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php
}

// Initialize plugin settings
function dtcalc_loader_settings_init()
{
  register_setting('dtcalc_loader_options', 'dtcalc_test_option');
}
add_action('admin_init', 'dtcalc_loader_settings_init');

// Display Diabetes Calculator tools in admin panel
function dtcalc_tools_page()
{
  ?>
  <div class="wrap">
    <h2 id="calculator"><?php esc_html_e('Diabetes Calculator Tools', 'diabetes-calculator') ?></h2>
    <p>
      <?php echo wp_kses( 
        __( 'Use this calculator to easily know the carbohydrates and <acronym title="Fat Protein Units">FPU</acronym> in your food.', 'diabetes-calculator' ),
        array( 
          'acronym' => array(
            'title' => array()
          ),
         ) ) ?>
    </p>
    <p>
      <?php esc_html_e('Input the quantities in each field as in nutrition label, and push "Calculate this!" button.', 'diabetes-calculator') ?>
    </p>
    <form method="post" action="">
      <div class="form-field">
        <label for="dtcalc_nutrient_grams"><?php esc_html_e('Grams of nutrient: ', 'diabetes-calculator') ?></label>
        <input type="text" name="dtcalc_nutrient_grams" id="dtcalc_nutrient_grams" size="10" maxlength="4"
          autocomplete="off">
      </div>
      <table class="form-table dtcalc-table">
        <tr valign="bottom">
          <th><?php esc_html_e('.', 'diabetes-calculator') ?></th>
          <th><?php esc_html_e('In 100 g of nutrient (as in nutrition label)', 'diabetes-calculator') ?></th>
          <th><?php esc_html_e('Total grams in nutrient (calculated)', 'diabetes-calculator') ?></th>
          <th><?php esc_html_e('Carbohydrates in nutrient (calculated)', 'diabetes-calculator') ?></th>
        </tr>
        <tr>
          <th scope="row"><?php esc_html_e('Fat', 'diabetes-calculator') ?></th>
          <td><input type="text" name="dtcalc_fat" id="dtcalc_fat"></td>
          <td><input type="text" name="dtcalc_fat_calc" id="dtcalc_fat_calc" readonly="readonly" tabindex="-1"></td>
          <td><input type="text" name="dtcalc_fat_ch_calc" id="dtcalc_fat_ch_calc" readonly="readonly" tabindex="-1"></td>
        </tr>
        <tr>
          <th scope="row"><?php esc_html_e('Carbohydrates', 'diabetes-calculator') ?></th>
          <td><input type="text" name="dtcalc_ch" id="dtcalc_ch"></td>
          <td><input type="text" name="dtcalc_ch_calc" id="dtcalc_ch_calc" readonly="readonly" tabindex="-1"></td>
          <td><input type="text" name="dtcalc_ch_ch_calc" id="dtcalc_ch_ch_calc" readonly="readonly" tabindex="-1"></td>
        </tr>
        <tr>
          <th scope="row"><?php esc_html_e('Proteins', 'diabetes-calculator') ?></th>
          <td><input type="text" name="dtcalc_prot" id="dtcalc_prot"></td>
          <td><input type="text" name="dtcalc_prot_calc" id="dtcalc_prot_calc" readonly="readonly" tabindex="-1"></td>
          <td><input type="text" name="dtcalc_prot_ch_calc" id="dtcalc_prot_ch_calc" readonly="readonly" tabindex="-1"></td>
        </tr>
        <tr>
          <td><input type="reset" value="<?php esc_attr_e('Clear the form', 'diabetes-calculator') ?>"
              class="button button-secondary" /></td>

          <td><button id="calculate">Calculate this!</button></td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form>
  </div>
  <div class="wrap dtcalc-results">
    <p>Total Carbohydrates: <span class="total_ch" id="total_ch"></span></p>
    <p>Total FPU: <span class="total_fpu" id="total_fpu"></span></p>
  </div>
  <div class="wrap">
    <hr>
    <h3 id="about"><?php esc_html_e('About', 'diabetes-calculator') ?></h3>
    <p>
      <?php esc_html_e('Meals high in fat and protein may require additional insulin delivered over several hours.', 'diabetes-calculator') ?>
    </p>
    <p>
      <?php esc_html_e('This calculator uses the following data in order to make calculations.', 'diabetes-calculator') ?>
    </p>
    <p><?php esc_html_e('Per gram of nutrient:', 'diabetes-calculator') ?></p>
    <ul class="simple-ul">
      <li><?php esc_html_e('1 g carbohydrate = 4 kcal', 'diabetes-calculator') ?></li>
      <li><?php esc_html_e('1 g protein = 4 kcal', 'diabetes-calculator') ?></li>
      <li><?php esc_html_e('1 g fat = 9 kcal', 'diabetes-calculator') ?></li>
    </ul>
    <h3 id="resources"><?php esc_html_e('Resources', 'diabetes-calculator') ?></h3>
    <p>
      <?php esc_html_e('The information and calculations provided by this plugin are obtained from several resources:', 'diabetes-calculator') ?>
    </p>
    <ul class="simple-ul dtcalc-resources-list">
      <?php
      global $dtcalc_resources_list;
      foreach ($dtcalc_resources_list as $data) {
        ?>
        <li>(<?php echo esc_html($data['lang']) ?>) <a href="<?php echo esc_attr($data['link']) ?>" target="_blank"
            rel="noopener noreferrer"><?php echo esc_html($data['name']) ?></a></li>
      <?php } ?>
    </ul>
  </div>

  <?php
}


function dtcalc_load_assets( $h )
{
  if ( 'tools_page_dtcalc_loader' != $h ) {
    return;
  }
  wp_register_style( 'dtcalc_admin_css', DTCALC_PLUGIN_URL . 'assets/dtcalc.css', false, '1.0.0' );
  wp_enqueue_style( 'dtcalc_admin_css' );
  wp_enqueue_script( 'dtcalc_js', DTCALC_PLUGIN_URL . 'assets/dtcalc.js', array(), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'dtcalc_load_assets' );

