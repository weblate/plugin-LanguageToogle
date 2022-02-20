<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\LanguageToogle;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugins\LanguagesManager\API as APILanguagesManager;
use Piwik\Plugins\LanguagesManager\LanguagesManager;
use Piwik\Version;

class Controller extends \Piwik\Plugin\Controller
{
    public function index() {
        Piwik::checkUserHasSuperUserAccess();
        $lang = Common::getRequestVar("lang");
        $returnModule = Common::getRequestVar("returnModule");
        $returnAction = Common::getRequestVar("returnAction");
        LanguagesManager::setLanguageForSession("");
        if (Version::VERSION == '4.7.1' || Version::VERSION == '4.7.0') {
            APILanguagesManager::getInstance()->setLanguageForUser(Piwik::getCurrentUserLogin(), $lang);
        }
        $this->redirectToIndex($returnModule, $returnAction);
    }
}
