<?php
namespace app\widgets\navigate;

use Yii;
use yii\base\Widget;

/**
 * Description of TopNavigate
 *
 * @author kot
 */
class NoteDisplay extends Widget
{
        
    public function run()
    {
        return $this->render('noteDisplay.php');
    }
}
