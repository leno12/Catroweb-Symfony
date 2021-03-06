<?php

namespace App\Catrobat\Services;

use App\Catrobat\Exceptions\InvalidCatrobatFileException;
use App\Catrobat\Exceptions\InvalidStorageDirectoryException;
use App\Entity\Program;
use App\Entity\ProgramManager;
use App\Utils\Utils;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ExtractedFileRepository
{
  private string $local_path;

  private string $web_path;

  private string $local_storage_path;

  private CatrobatFileExtractor $file_extractor;

  private ProgramManager $program_manager;

  private ProgramFileRepository $program_file_repo;

  private LoggerInterface $logger;

  public function __construct(ParameterBagInterface $parameter_bag, CatrobatFileExtractor $file_extractor,
                              ProgramManager $program_manager, ProgramFileRepository $program_file_repo,
                              LoggerInterface $logger)
  {
    $local_extracted_path = $parameter_bag->get('catrobat.file.extract.dir');
    $web_extracted_path = $parameter_bag->get('catrobat.file.extract.path');
    $local_storage_path = $parameter_bag->get('catrobat.file.storage.dir');

    if (!is_dir($local_extracted_path))
    {
      throw new InvalidStorageDirectoryException($local_extracted_path.' is not a valid directory');
    }
    $this->local_storage_path = $local_storage_path;
    $this->local_path = $local_extracted_path;
    $this->web_path = $web_extracted_path;
    $this->file_extractor = $file_extractor;
    $this->program_manager = $program_manager;
    $this->program_file_repo = $program_file_repo;
    $this->logger = $logger;
  }

  public function ensureProjectIsExtracted(Program $project): bool
  {
    try
    {
      $hash = $project->getExtractedDirectoryHash();
      if (null === $hash || !file_exists($this->local_path.$hash))
      {
        $this->extractProject($project);
      }
    }
    catch (Exception $e)
    {
      return false;
    }

    return true;
  }

  public function loadProgramExtractedFile(Program $program): ?ExtractedCatrobatFile
  {
    try
    {
      $hash = $program->getExtractedDirectoryHash();

      return new ExtractedCatrobatFile($this->local_path.$hash.'/', $this->web_path.$hash.'/', $hash);
    }
    catch (InvalidCatrobatFileException $e)
    {
      //need to extract first
      unset($e);
    }

    try
    {
      return $this->extractProject($program);
    }
    catch (Exception $e)
    {
      return null;
    }
  }

  public function removeProgramExtractedFile(Program $program): void
  {
    try
    {
      $hash = $program->getExtractedDirectoryHash();

      if (null === $hash)
      {
        return; // nothing to do
      }

      $extract_dir = $this->local_path.$hash.'/';
      Utils::removeDirectory($extract_dir);
      $program->setExtractedDirectoryHash(null);
      $this->program_manager->save($program);
    }
    catch (Exception $e)
    {
      $this->logger->error(
        "Removing extracted project files failed with code '".$e->getCode().
        "' and message: '".$e->getMessage()."'"
      );
    }
  }

  private function extractProject(Program $program): ExtractedCatrobatFile
  {
    $program_file = $this->program_file_repo->getProgramFile($program->getId());
    $extracted_file = $this->file_extractor->extract($program_file);
    $program->setExtractedDirectoryHash($extracted_file->getDirHash());
    $this->program_manager->save($program);

    return $extracted_file;
  }
}
