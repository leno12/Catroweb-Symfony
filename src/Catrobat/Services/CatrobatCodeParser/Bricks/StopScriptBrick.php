<?php

namespace App\Catrobat\Services\CatrobatCodeParser\Bricks;

use App\Catrobat\Services\CatrobatCodeParser\Constants;

class StopScriptBrick extends Brick
{
  protected function create(): void
  {
    $this->type = Constants::STOP_SCRIPT_BRICK;
    $this->caption = 'Stop Script';
    $this->setImgFile(Constants::CONTROL_BRICK_IMG);
  }
}
