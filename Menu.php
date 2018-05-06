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
            $additionalParams = ["returnModule" => Piwik::getModule(), "returnAction" => Piwik::getAction()];
            $settings = new UserSettings();
            if (empty($settings->availableLanguages->getValue())) {
                return false;
            }
            $languages = [];
            foreach (API::getInstance()->getAvailableLanguageNames() as $lang) {
                $languages[$lang["code"]] = $lang;
            }
            foreach ($settings->availableLanguages->getValue() as $code) {
                if (isset($languages[$code])) {
                    $additionalParams["lang"] = $code;
                    $menu->addItem($languages[$code]["name"], null, $this->urlForDefaultAction($additionalParams), $orderId = 30);
                }
            }
        }
    }
}
