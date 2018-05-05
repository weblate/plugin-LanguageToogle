<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\LanguageToogle;

use Piwik\Piwik;
use Piwik\Plugins\LanguagesManager\API;
use Piwik\Settings\FieldConfig;
use Piwik\Settings\Setting;

class UserSettings extends \Piwik\Settings\Plugin\UserSettings
{
    /** @var Setting */
    public $availableLanguages;

    protected function init() {
        $this->availableLanguages = $this->createAvailableLanguagesSetting();
    }

    private function createAvailableLanguagesSetting()
    {
        return $this->makeSetting('availableLanguages', $default = false, FieldConfig::TYPE_ARRAY, function (FieldConfig $field) {
            $languageList = [];
            $languages = API::getInstance()->getAvailableLanguagesInfo();
            foreach ($languages as $language) {
                $languageList[$language['code']] = $language['name'] . ' (' . $language['english_name'] . ')';
            }
            $field->title = Piwik::translate('LanguageToogle_SettingsTitle');
            $field->inlineHelp = Piwik::translate('LanguageToogle_SelectLanguages');
            $field->uiControl = FieldConfig::UI_CONTROL_MULTI_SELECT;
            $field->availableValues = $languageList;
        });
    }
}
