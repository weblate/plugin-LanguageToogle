<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\LanguageToogle;

use Piwik\Menu\MenuTop;
use Piwik\Piwik;
use Piwik\Plugins\LanguagesManager\API;


class Menu extends \Piwik\Plugin\Menu
{
    public function configureTopMenu(MenuTop $menu) {
        if (Piwik::hasUserSuperUserAccess()) {
            $settings = new UserSettings();
            if (empty($settings->availableLanguages->getValue())) {
                return false;
            }
            $languages = API::getInstance()->getAvailableLanguageNames();

            foreach ($settings->availableLanguages->getValue() as $code) {
                foreach ($languages as $lang) {
                    if ($lang["code"] == $code) {
                        $menu->addItem($lang["name"], null, $this->urlForDefaultAction(["lang" => $code]), $orderId = 30);
                    }
                }
            }
        }
    }
}
