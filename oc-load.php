<?php
/*
 *  Copyright 2020 Mindstellar Osclass
 *  Maintained and supported by Mindstellar Community
 *  https://github.com/mindstellar/Osclass
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use mindstellar\Csrf;

if (!defined('ABS_PATH')) {
    define('ABS_PATH', __DIR__ . '/');
}

define('LIB_PATH', ABS_PATH . 'oc-includes/');

if (!file_exists(ABS_PATH . 'config.php')) {
    require_once LIB_PATH . 'osclass/helpers/hErrors.php';

    $title   = 'Osclass &raquo; Error';
    $message =
        'There doesn\'t seem to be a <code>config.php</code> file. Osclass isn\'t installed. '
        . '<a href="https://osclass.discourse.group/">Need more help?</a></p>';
    $message .= '<p><a class="button" href="' . osc_get_absolute_url()
        . 'oc-includes/osclass/install.php">'
        . 'Install</a></p>';
    osc_die($title, $message);
}

// load osclass configuration
require_once ABS_PATH . 'config.php';

// load default constants
require_once LIB_PATH . 'osclass/default-constants.php';

// Sets PHP error handling
if (OSC_DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);

    if (OSC_DEBUG_LOG) {
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        ini_set('error_log', CONTENT_PATH . 'debug.log');
    }
} else {
    error_reporting(
        E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE
        | E_USER_ERROR | E_USER_WARNING
    );
}
//Load Autoloader
require_once LIB_PATH . 'vendor/autoload.php';

require_once LIB_PATH . 'osclass/helpers/hDatabaseInfo.php';
require_once LIB_PATH . 'osclass/helpers/hPreference.php';

// check if Osclass is installed
if (!Preference::newInstance()->get('osclass_installed')) {
    require_once LIB_PATH . 'osclass/helpers/hErrors.php';

    $title   = 'Osclass &raquo; Error';
    $message =
        'Osclass isn\'t installed. <a href="https://osclass.discourse.group/">Need more help?</a></p>';
    $message .= '<p><a class="button" href="' . osc_get_absolute_url()
        . 'oc-includes/osclass/install.php">Install</a></p>';

    osc_die($title, $message);
}
require_once LIB_PATH . 'osclass/helpers/hDefines.php';
require_once LIB_PATH . 'osclass/helpers/hLocale.php';
require_once LIB_PATH . 'osclass/helpers/hMessages.php';
require_once LIB_PATH . 'osclass/helpers/hUsers.php';
require_once LIB_PATH . 'osclass/helpers/hItems.php';
require_once LIB_PATH . 'osclass/helpers/hSearch.php';
require_once LIB_PATH . 'osclass/helpers/hUtils.php';
require_once LIB_PATH . 'osclass/helpers/hCategories.php';
require_once LIB_PATH . 'osclass/helpers/hTranslations.php';
require_once LIB_PATH . 'osclass/helpers/hSecurity.php';
require_once LIB_PATH . 'osclass/helpers/hSanitize.php';
require_once LIB_PATH . 'osclass/helpers/hValidate.php';
require_once LIB_PATH . 'osclass/helpers/hPage.php';
require_once LIB_PATH . 'osclass/helpers/hPagination.php';
require_once LIB_PATH . 'osclass/helpers/hPremium.php';
require_once LIB_PATH . 'osclass/helpers/hTheme.php';
require_once LIB_PATH . 'osclass/helpers/hLocation.php';
require_once LIB_PATH . 'osclass/utils.php';
require_once LIB_PATH . 'osclass/formatting.php';
require_once LIB_PATH . 'osclass/locales.php';
require_once LIB_PATH . 'osclass/helpers/hPlugins.php';
require_once LIB_PATH . 'osclass/emails.php';
require_once LIB_PATH . 'osclass/alerts.php';
require_once LIB_PATH . 'osclass/functions.php';
require_once LIB_PATH . 'osclass/helpers/hAdminMenu.php';
require_once LIB_PATH . 'osclass/helpers/hCache.php';
require_once LIB_PATH . 'osclass/compatibility.php';


if (!defined('OSC_CRYPT_KEY')) {
    define('OSC_CRYPT_KEY', osc_get_preference('crypt_key'));
}

osc_cache_init();

define('__OSC_LOADED__', true);
Params::init();
Session::newInstance()->session_start();

if (osc_timezone()) {
    date_default_timezone_set(osc_timezone());
}


Scripts::init();
Styles::init();

// register scripts
osc_register_script('jquery', osc_assets_url('jquery/jquery.min.js'));
osc_register_script('jquery-migrate', osc_assets_url('jquery-migrate/jquery-migrate.min.js'), 'jquery');
osc_register_script('jquery-ui', osc_assets_url('jquery-ui/jquery-ui.min.js'), 'jquery');

//osc_register_script('jquery-json', osc_assets_url('js/jquery.json.js'), 'jquery');
//Not used in osclass core, removed.
//osc_register_script('fancybox', osc_assets_url('js/fancybox/jquery.fancybox.pack.js'), array('jquery'));

osc_register_script('jquery-treeview', osc_assets_url('jquery-treeview/jquery.treeview.js'), 'jquery');
osc_register_script('jquery-nested', osc_assets_url('jquery-ui-nested/jquery-ui-nested.js'), 'jquery-ui');
osc_register_script('jquery-validate', osc_assets_url('jquery-validation/jquery.validate.min.js'), 'jquery');
osc_register_script('jquery-validate-additional', osc_assets_url('jquery-validation/additional-methods.min.js'), 'jquery-validate');
osc_register_script('jquery-spectrum', osc_assets_url('spectrum-colorpicker/spectrum.js'), 'jquery');
osc_register_script('tiny_mce', osc_assets_url('tinymce/tinymce.min.js'));

//Legacy js libraries
osc_register_script('tabber', osc_assets_url('osclass-legacy/js/tabber-minimized.js'), 'jquery');
osc_register_script('colorpicker', osc_assets_url('osclass-legacy/js/colorpicker/js/colorpicker.js'));
osc_register_script('php-date', osc_assets_url('osclass-legacy/js/date.js'));
osc_register_script('jquery-fineuploader', osc_assets_url('osclass-legacy/js/fineuploader/jquery.fineuploader.min.js'), 'jquery');



Plugins::init();
if (OC_ADMIN) {
    // init admin menu
    AdminMenu::newInstance()->init();
    $functions_path = AdminThemes::newInstance()->getCurrentThemePath() . 'functions.php';
    if (file_exists($functions_path)) {
        require_once $functions_path;
    }
}
WebThemes::init();
Translation::init();
Csrf::init();
Rewrite::newInstance()->init();
