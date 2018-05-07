<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\LanguageToogle;

use function PHPSTORM_META\type;
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
        if (!empty($this->availableLanguages->getValue()) && gettype($this->availableLanguages->getValue()[0]) == "string") {
            $this->availableLanguages->setValue([]);
        }
    }

    private function createAvailableLanguagesSetting() {
        return $this->makeSetting('availableLanguages', array(), FieldConfig::TYPE_ARRAY, function (FieldConfig $field) {
            $languageList = [];
            $languages = API::getInstance()->getAvailableLanguagesInfo();
            foreach ($languages as $language) {
                $languageList[$language['code']] = $language['name'] . ' (' . $language['english_name'] . ')';
            }
            $field->title = Piwik::translate('LanguageToogle_SettingsTitle');
            $field->description = Piwik::translate('LanguageToogle_Description');
            $field->uiControl = FieldConfig::UI_CONTROL_MULTI_TUPLE;
            $field1 = new FieldConfig\MultiPair(Piwik::translate('LanguageToogle_Language'), 'languageCode', FieldConfig::UI_CONTROL_SINGLE_SELECT);
            $field1->availableValues = $languageList;
            $field->uiControlAttributes['field1'] = $field1->toArray();
        });
    }
}
