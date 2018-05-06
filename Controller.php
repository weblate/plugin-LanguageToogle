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
use Piwik\Plugins\LanguagesManager\LanguagesManager;

class Controller extends \Piwik\Plugin\Controller
{
    public function index() {
        Piwik::checkUserHasSuperUserAccess();
        $lang = Common::getRequestVar("lang");
        $returnModule = Common::getRequestVar("returnModule");
        $returnAction = Common::getRequestVar("returnAction");
        LanguagesManager::setLanguageForSession($lang);
        $this->redirectToIndex($returnModule, $returnAction);
    }
}
