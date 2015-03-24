<?php

namespace Catrobat\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Catrobat\AppBundle\Model\ProgramManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Catrobat\AppBundle\Services\ProgramFileRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DownloadProgramController extends Controller
{

  /**
   * @Route("/download/{id}.catrobat", name="download", defaults={"_format": "json"})
   * @Method({"GET"})
   */
  function downloadProgramAction(Request $request, $id)
  {
    /* @var $program_manager ProgramManager */
    $program_manager = $this->get("programmanager");
    /* @var $file_repository ProgramFileRepository */
    $file_repository = $this->get("filerepository");
    
    $program = $program_manager->find($id);
    if (!$program)
    {
      throw new NotFoundHttpException();
    }
    if (!$program->isVisible())
    {
      throw new NotFoundHttpException();
    }
    
    $file = $file_repository->getProgramFile($id);
    if ($file->isFile())
    {
      return new BinaryFileResponse($file);
    }
    throw new NotFoundHttpException();
  }
}