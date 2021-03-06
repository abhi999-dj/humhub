<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\web\pwa\controllers;

use humhub\components\Controller;
use humhub\modules\web\pwa\widgets\SiteIcon;
use humhub\modules\web\Module;
use Yii;
use yii\helpers\Url;

/**
 * Class ManifestController is responsible to generate the Manifest JSON output.
 *
 * @since 1.4
 *
 * @property Module $module
 * @package humhub\modules\ui\controllers
 */
class ManifestController extends Controller
{

    /**
     * @var array the manifest
     */
    public $manifest = [];


    public function actionIndex()
    {
        $this->handleIcons();
        $this->handlePwa();

        return $this->asJson($this->manifest);
    }

    private function handlePwa()
    {
        $this->manifest['display'] = 'standalone';
        $this->manifest['start_url'] = Url::home(true);
        $this->manifest['short_name'] = Yii::$app->name;
        $this->manifest['name'] = Yii::$app->name;
        $this->manifest['background_color'] = Yii::$app->view->theme->variable('primary');
        $this->manifest['theme_color'] = Yii::$app->view->theme->variable('primary');
    }

    private function handleIcons()
    {
        $this->manifest['icons'] = [];

        foreach ([48, 72, 96, 192, 512] as $size) {
            $this->manifest['icons'][] = [
                'src' => SiteIcon::getUrl($size),
                'type' => 'image/png',
                'sizes' => $size . 'x' . $size
            ];
        }
    }
}
