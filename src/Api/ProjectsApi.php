<?php

namespace App\Api;

use App\Catrobat\Forms\FeaturedImageConstraint;
use App\Catrobat\Responses\ApiResponse;
use App\Catrobat\Services\FeaturedImageRepository;
use App\Catrobat\Services\Formatter\ElapsedTimeStringFormatter;
use App\Entity\ProgramManager;
use App\Repository\FeaturedRepository;
use OpenAPI\Server\Api\ProjectsApiInterface;
use OpenAPI\Server\Model\Flavor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class ProjectsApi extends AbstractController implements ProjectsApiInterface
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
   * @var FeaturedRepository
   */
  private  $featured_repository;
  /**
   * @var FeaturedImageRepository
   */
  private  $featured_image_repository;
  /**
   * ProjectsApi constructor.
   *
   * @param ProgramManager $program_manager
   *
   * @param SessionInterface $session
   *
   * @param ElapsedTimeStringFormatter $time_formatter
   * @param FeaturedRepository $featured_repository
   * @param FeaturedImageRepository $featured_image_repository
   */
  public function __construct(ProgramManager $program_manager, SessionInterface $session,
                              ElapsedTimeStringFormatter $time_formatter, FeaturedRepository $featured_repository,
                              FeaturedImageRepository $featured_image_repository)
  {
    $this->program_manager = $program_manager;
    $this->session = $session;
    $this->time_formatter = $time_formatter;
    $this->featured_repository = $featured_repository;
    $this->featured_image_repository = $featured_image_repository;
  }

  /**
   * @inheritDoc
   */
  public function projectProjectIdGet($projectId, &$responseCode, array &$responseHeaders)
  {
    $responseCode = Response::HTTP_NOT_IMPLEMENTED;
    // TODO: Implement projectProjectIdGet() method.
  }

  /**
   * @inheritDoc
   */
  public function projectsFeaturedGet($platform = null, $maxVersion = null, $limit = 20, $offset = 0, Flavor $flavor = null, &$responseCode, array &$responseHeaders)
  {
    if($maxVersion == null)
    {
      $maxVersion = "0";
    }
    $programs =$this->featured_repository->getFeaturedPrograms($flavor, $limit, $offset, $platform, $maxVersion);
    $responseCode = Response::HTTP_OK;
    $response = new ApiResponse($this->program_manager, $this->session, $this->time_formatter, $this->container, $this->featured_image_repository);
    return $response->getFeaturedProgramsInformation($programs);

  }

  /**
   * @inheritDoc
   */
  public function projectsMostDownloadedGet($maxVersion = null, $limit = 20, $offset = 0, Flavor $flavor = null, &$responseCode, array &$responseHeaders)
  {
    $responseCode = Response::HTTP_NOT_IMPLEMENTED;
    // TODO: Implement projectsMostDownloadedGet() method.
  }

  /**
   * @inheritDoc
   */
  public function projectsMostViewedGet($maxVersion = null, $limit = 20, $offset = 0, Flavor $flavor = null, &$responseCode, array &$responseHeaders)
  {
    $responseCode = Response::HTTP_NOT_IMPLEMENTED;
    // TODO: Implement projectsMostViewedGet() method.
  }

  /**
   * @inheritDoc
   */
  public function projectsPublicUserUserIdGet($userId, $maxVersion = null, $limit = 20, $offset = null, &$responseCode, array &$responseHeaders)
  {
    $responseCode = Response::HTTP_NOT_IMPLEMENTED;
    // TODO: Implement projectsPublicUserUserIdGet() method.
  }

  /**
   * @inheritDoc
   */
  public function projectsRandomProgramsGet($maxVersion = null, $limit = 20, $offset = 0, Flavor $flavor = null, &$responseCode, array &$responseHeaders)
  {
    $responseCode = Response::HTTP_NOT_IMPLEMENTED;
    // TODO: Implement projectsRandomProgramsGet() method.
  }

  /**
   * @inheritDoc
   */
  public function projectsRecentGet($maxVersion = null, $limit = 20, $offset = 0, Flavor $flavor = null, &$responseCode, array &$responseHeaders)
  {
    $responseCode = Response::HTTP_NOT_IMPLEMENTED;
    // TODO: Implement projectsRecentGet() method.
  }

  /**
   * @inheritDoc
   */
  public function projectsSearchGet($maxVersion = null, $limit = 20, $offset = 0, Flavor $flavor = null, &$responseCode, array &$responseHeaders)
  {
    $responseCode = Response::HTTP_NOT_IMPLEMENTED;
    // TODO: Implement projectsSearchGet() method.
  }

  /**
   * @inheritDoc
   */
  public function projectsUploadPost($token, $checksum = null, UploadedFile $file = null, Flavor $flavor = null, array $tags = null, &$responseCode, array &$responseHeaders)
  {
    $responseCode = Response::HTTP_NOT_IMPLEMENTED;
    // TODO: Implement projectsUploadPost() method.
  }

  /**
   * @inheritDoc
   */
  public function projectsUserUserIdGet($userId, $maxVersion = null, $limit = 20, $offset = null, $token, &$responseCode, array &$responseHeaders)
  {
    $responseCode = Response::HTTP_NOT_IMPLEMENTED;
    // TODO: Implement projectsUserUserIdGet() method.
  }
}