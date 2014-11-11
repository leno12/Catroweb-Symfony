<?php

namespace Catrobat\AppBundle\Services;

use Catrobat\AppBundle\Services\Time;
use Symfony\Component\Translation\Translator;

class ElapsedTimeString
{
  private $translator;
  private $time;
  
  public function __construct(Translator $translator, Time $time)
  {
    $this->translator = $translator;
    $this->time = $time;
  }
  
  public function getElapsedTime($timestamp)
  {
    $elapsed = $this->time->getTime() - $timestamp;

    if ($elapsed <= 3540)
    {
      $minutes = floor($elapsed / 60);
      return $this->translator->transChoice("time.minutes.ago", $minutes, array("%count%" => $minutes), "catroweb");
    }
    else if ($elapsed <= 82800)
    {
      $hours = floor($elapsed / 3600);
      return $this->translator->transChoice("time.hours.ago", $hours, array("%count%" => $hours), "catroweb");
    }
    else if ($elapsed <= 2505600)
    {
      $days = floor($elapsed / 86400);
      return $this->translator->transChoice("time.days.ago", $days, array("%count%" => $days), "catroweb");
    }
    else if ($elapsed <= 28927800)
    {
      $months = floor($elapsed / 2629800);
      return $this->translator->transChoice("time.months.ago", $months, array("%count%" => $months), "catroweb");
    }

    $years = floor($elapsed / 31557600);
    return $this->translator->transChoice("time.years.ago", $years, array("%count%" => $years), "catroweb");
  }

}