<?php

use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use PHPUnit\Framework\Assert;


/**
 * Api Feature context.
 */
class ApiNewFeatureContext extends BaseContext
{

  /**
   * @var null
   */
  private $username;

  /**
   * @var array
   */
  private $request_parameters;

  /**
   * @var string
   */
  private $hostname;

  /**
   * @var bool
   */
  private $secure;

  /**
   * @var array
   */
  private $checked_catrobat_remix_forward_ancestor_relations;

  /**
   * @var array
   */
  private $checked_catrobat_remix_forward_descendant_relations;

  /**
   * @var array
   */
  private $checked_catrobat_remix_backward_relations;


  /**
   * @var array
   */
  private $files = [];


  private $old_metadata_hash = "";

  /**
   * FeatureContext constructor.
   *
   * @param $error_directory
   */
  public function __construct($error_directory)
  {
    parent::__construct();
    $this->setErrorDirectory($error_directory);
    $this->username = null;
    $this->request_parameters = [];
    $this->files = [];
    $this->hostname = 'localhost';
    $this->secure = false;
    $this->checked_catrobat_remix_forward_ancestor_relations = [];
    $this->checked_catrobat_remix_forward_descendant_relations = [];
    $this->checked_catrobat_remix_backward_relations = [];
  }

  /**
   * @BeforeScenario
   */
  public function clearData()
  {
    $em = $this->getManager();
    $metaData = $em->getMetadataFactory()->getAllMetadata();
    $new_metadata_hash = md5(json_encode($metaData));
    if ($this->old_metadata_hash === $new_metadata_hash)
    {
      return;
    };
    $this->old_metadata_hash = $new_metadata_hash;
    $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
    $tool->dropSchema($metaData);
    $tool->createSchema($metaData);
  }

  /**
   * @BeforeScenario @RealGeocoder
   */
  public function activateRealGeocoderService()
  {
    $this->getSymfonyService('App\Catrobat\Services\StatisticsService')->useRealService(true);
  }

  /**
   * @AfterScenario @RealGeocoder
   */
  public function deactivateRealGeocoderService()
  {
    $this->getSymfonyService('App\Catrobat\Services\StatisticsService')->useRealService(false);
  }

  /**
   *
   */
  private function prepareValidRegistrationParameters()
  {
    $this->request_parameters['registrationUsername'] = 'newuser';
    $this->request_parameters['registrationPassword'] = 'topsecret';
    $this->request_parameters['registrationEmail'] = 'someuser@example.com';
    $this->request_parameters['registrationCountry'] = 'at';
  }


  /**
   * @Given /^there are users:$/
   * @param TableNode $table
   */
  public function thereAreUsers(TableNode $table)
  {
    $users = $table->getHash();
    for ($i = 0; $i < count($users); ++$i)
    {
      $this->insertUser(@[
        'id'       => $users[$i]['id'],
        'name'     => $users[$i]['name'],
        'email'    => $users[$i]['email'],
        'token'    => isset($users[$i]['token']) ? $users[$i]['token'] : "",
        'password' => isset($users[$i]['password']) ? $users[$i]['password'] : "",
      ]);
    }
  }

  /**
   * @Given /^there are programs:$/
   * @param TableNode $table
   *
   * @throws ORMException
   * @throws OptimisticLockException
   */
  public function thereArePrograms(TableNode $table)
  {
    $programs = $table->getHash();

    for ($i = 0; $i < count($programs); ++$i)
    {
      $user = $this->getUserManager()->findOneBy([
        'username' => isset($programs[$i]['owned by']) ? $programs[$i]['owned by'] : "",
      ]);
      @$config = [
        'id'                  => $programs[$i]['id'],
        'name'                => $programs[$i]['name'],
        'description'         => $programs[$i]['description'],
        'views'               => $programs[$i]['views'],
        'downloads'           => $programs[$i]['downloads'],
        'uploadtime'          => $programs[$i]['upload time'],
        'apk_status'          => $programs[$i]['apk_status'],
        'catrobatversionname' => $programs[$i]['version'],
        'language_version'    => $programs[$i]['language version'],
        'directory_hash'      => $programs[$i]['directory_hash'],
        'filesize'            => @$programs[$i]['FileSize'],
        'visible'             => isset($programs[$i]['visible']) ? $programs[$i]['visible'] == 'true' : true,
        'approved'            => (isset($programs[$i]['approved_by_user']) && $programs[$i]['approved_by_user'] == '')
          ? null : true,
        'tags'                => isset($programs[$i]['tags_id']) ? $programs[$i]['tags_id'] : null,
        'extensions'          => isset($programs[$i]['extensions']) ? $programs[$i]['extensions'] : null,
        'remix_root'          => isset($programs[$i]['remix_root']) ? $programs[$i]['remix_root'] == 'true' : true,
        'debug'               => isset($programs[$i]['debug']) ? $programs[$i]['debug'] == 'true' : false,
      ];

      $this->insertProgram($user, $config);
    }
  }


  /**
   * @Given /^I have a parameter "([^"]*)" with value "([^"]*)"$/
   * @param $name
   * @param $value
   */
  public function iHaveAParameterWithValue($name, $value)
  {

    $this->request_parameters[$name] = $value;
  }


  /**
   * @When /^I GET "([^"]*)" with these parameters$/
   * @param $url
   */
  public function iGetWithTheseParameters($url)
  {
    $uri = 'http://' . $this->hostname . $url . '?' . http_build_query($this->request_parameters);
    $this->getClient()->request('GET', $uri, [], $this->files, [
      'HTTP_HOST'   => $this->hostname,
      'HTTPS'       => $this->secure,
      'HTTP_ACCEPT' => "application/json",
    ]);
  }

  /**
   * @When /^I GET "([^"]*)" without the accept json header$/
   * @param $url
   */
  public function iGetWithoutAcceptHeader($url)
  {
    $uri = 'http://' . $this->hostname . $url . '?' . http_build_query($this->request_parameters);
    $this->getClient()->request('GET', $uri, [], $this->files, [
      'HTTP_HOST' => $this->hostname,
      'HTTPS'     => $this->secure,
    ]);
  }


  /**
   * @Then /^I should get (\d+) programs in random order:$/
   * @param              $program_count
   * @param PyStringNode $string
   */
  public function iShouldGetTheJsonObjectInRandomOrder($program_count, PyStringNode $string)
  {
    $response = $this->getClient()->getResponse();
    Assert::assertEquals(200, $response->getStatusCode());
    $expected_json = json_decode($string, true);
    $response_json = json_decode($response->getContent(), true);

    $count_matches = 0;
    foreach ($expected_json as $item)
    {

      foreach ($response_json as $item_2)
      {

        if ($item === $item_2)
        {
          $count_matches++;

        }
      }
    }
    Assert::assertEquals($program_count, $count_matches, 'Wrong number of random programs');
  }


  /**
   * @Given /^The status code of the response should be "([^"]*)"$/
   * @param $status_code
   */
  public function iShouldGetStatusCode($status_code)
  {
    $response = $this->getClient()->getResponse();
    Assert::assertEquals($status_code, $response->getStatusCode());
  }


}
