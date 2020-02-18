<?php


namespace App\Catrobat\Responses;


use App\Catrobat\Services\FeaturedImageRepository;
use App\Catrobat\Services\Formatter\ElapsedTimeStringFormatter;
use App\Entity\FeaturedProgram;
use App\Entity\Program;
use App\Entity\ProgramManager;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ApiResponse extends AbstractController
{
  /**
   * @var ProgramManager
   */
  private $program_manager;

  /**
   * @var SessionInterface
   */
  private $session;

  /**
   * @var ElapsedTimeStringFormatter
   */
  private $time_formatter;
  /**
   * @var FeaturedImageRepository
   */
  private $featured_image_repository;



  /**
   * ApiResponse constructor.
   *
   * @param ProgramManager             $program_manager
   *
   * @param SessionInterface           $session
   *
   * @param ElapsedTimeStringFormatter $time_formatter
   *
   * @param ContainerInterface         $container
   * @param FeaturedImageRepository    $feaatured_image_repository
   *
   */
  public function
  __construct(ProgramManager $program_manager, SessionInterface $session,
              ElapsedTimeStringFormatter $time_formatter, ContainerInterface $container,
              FeaturedImageRepository $featured_image_repository)
  {
    $this->program_manager = $program_manager;
    $this->session = $session;
    $this->time_formatter = $time_formatter;
    $this->setContainer($container);
    $this->featured_image_repository = $featured_image_repository;
  }


  /**
   *
   * @param Program[] $programs
   *
   * @return array
   */
  public function getInformation($programs)
  {
    $results = [];
    foreach ($programs as &$program)
    {
      $result = [
        'id'               => $program->getId(),
        'name'             => $program->getName(),
        'author'           => $program->getUser()->getUserName(),
        'description'      => $program->getDescription(),
        'version'          => $program->getCatrobatVersionName(),
        'views'            => $program->getViews(),
        'download'         => $program->getDownloads(),
        'private'          => $program->getPrivate(),
        'flavor'           => $program->getFlavor(),
        'uploaded'         => $program->getUploadedAt()->getTimestamp(),
        'uploaded_string'  => $this->time_formatter->getElapsedTime($program->getUploadedAt()
          ->getTimestamp()),
        'screenshot_large' => $this->program_manager->getScreenshotLarge($program->getId()),
        'screenshot_small' => $this->program_manager->getScreenshotSmall($program->getId()),
        'projectUrl'       => ltrim($this->generateUrl('program', [
          'flavor' => $this->session->get('flavor_context'),
          'id'     => $program->getId(),
        ]), '/'),
        'downloadUrl'      => ltrim($this->generateUrl('download', [
          'id' => $program->getId(),
        ]), '/'),
        'filesize'         => $program->getFilesize() / 1048576,
      ];
      array_push($results, $result);
    }

    return $results;
  }


  /**
   *
   * @param FeaturedProgram[] $programs
   *
   * @return array
   */
  public function getFeaturedProgramsInformation($programs)
  {

    $results = [];
    foreach ($programs as &$featured_program)
    {
      $result = [
        'id'               => $featured_program->getId(),
        'name'             => $featured_program->getProgram()->getName(),
        'author'           => $featured_program->getProgram()->getUser()->getUsername(),
        'featured_image'   => $this->featured_image_repository->getWebPath($featured_program->getId(), $featured_program->getImageType()),

      ];
      array_push($results, $result);
    }

    return $results;
  }

}