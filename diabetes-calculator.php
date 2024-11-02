<?php
/**
 * Plugin Name:       Diabetes Calculator
 * Plugin URI:        https://github.com/interdevel/diabetes-calculator/
 * Description:       A WordPress plugin to help with diabetes care.
 * Version:           0.0.1
 * Requires at least: 5.3
 * Requires PHP:      7.4
 * Author:            Luis Molina
 * Author URI:        https://github.com/interdevel
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       diabetes-calculator
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

// Add menu items in admin panel
function dtcalc_loader_menu() {
    add_options_page( 
      __( 'Diabetes Calculator', 'diabetes-calculator' ), 
      __( 'Diabetes Calculator', 'diabetes-calculator' ), 
      'manage_options', 'dtcalc_loader', 'dtcalc_loader_page');
    add_management_page( 
      __( 'Diabetes Calculator', 'diabetes-calculator' ), 
      __( 'Diabetes Calculator', 'diabetes-calculator' ), 
      'manage_options', 'dtcalc_loader', 'dtcalc_tools_page');
}
add_action('admin_menu', 'dtcalc_loader_menu');

// Display plugin settings page
function dtcalc_loader_page() {
    ?>
    <div class="wrap">
        <h2><?php _e( 'Diabetes Calculator Settings', 'diabetes-calculator' ) ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'dtcalc_loader_options' ); ?>
            <?php do_settings_sections( 'dtcalc_loader_options' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e( 'Test option: ', 'diabetes-calculator' ) ?></th>
                    <td><input type="text" name="dtcalc_id" value="<?php echo esc_attr( get_option('dtcalc_test_option') ); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Initialize plugin settings
function dtcalc_loader_settings_init() {
    register_setting( 'dtcalc_loader_options', 'dtcalc_test_option' );
}
add_action( 'admin_init', 'dtcalc_loader_settings_init' );

// Display Diabetes Calculator tools in admin panel
function dtcalc_tools_page() {
  ?>
  <div class="wrap">
      <h2 id="calculator"><?php _e( 'Diabetes Calculator Tools', 'diabetes-calculator' ) ?></h2>
      <p><?php _e( 'Use this calculator to easily know the carbohydrates and <acronym title="">UGP</acronym> in your food.', 'diabetes-calculator' ) ?></p>
      <p><?php _e( 'Input the quantities in each field and push "Calc!" button.', 'diabetes-calculator' ) ?></p>
      <form method="post" action="">
          <table class="form-table">
              <tr valign="bottom">
                  <th><?php _e( 'Fat', 'diabetes-calculator' ) ?></th>
                  <th><?php _e( 'Carbohydrates', 'diabetes-calculator' ) ?></th>
                  <th><?php _e( 'Proteins', 'diabetes-calculator' ) ?></th>
              </tr>
              <tr>
                <td><input type="text" name="dtcalc_fat" id="dtcalc_fat"></td>
                <td><input type="text" name="dtcalc_ch" id="dtcalc_ch"></td>
                <td><input type="text" name="dtcalc_prot" id="dtcalc_prot"></td>
              </tr>
          </table>
          <?php submit_button( __( 'Reset', 'diabetes-calculator' ), 'secondary' ); ?>
          <?php submit_button( __( 'Calc!', 'diabetes-calculator' ) ); ?>
      </form>
  </div>
  <div class="wrap">
    <h2 id="about"><?php _e( 'About', 'diabetes-calculator' ) ?></h2>
    <p><?php _e( 'Meals high in fat and protein may require additional insulin delivered over several hours.', 'diabetes-calculator' ) ?></p>
    <p><?php _e( 'This calculator uses the following data in order to make calculations.', 'diabetes-calculator' ) ?></p>
    <p><?php _e( 'Per gram of nutrient:', 'diabetes-calculator' ) ?></p>
    <ul>
      <li><?php _e( '1 g carbohydrate = 4 kcal', 'diabetes-calculator' ) ?></li>
      <li><?php _e( '1 g protein = 4 kcal', 'diabetes-calculator' ) ?></li>
      <li><?php _e( '1 g fat = 9 kcal', 'diabetes-calculator' ) ?></li>
    </ul>
    <h2 id="resources"><?php _e( 'Resources', 'diabetes-calculator' ) ?></h2>
    <p><?php _e( 'The information provided by this plugin is obtained from different resources:', 'diabetes-calculator' ) ?></p>
  </div>
  <?php
}

