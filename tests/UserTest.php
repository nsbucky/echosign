<?php

use Mockery as m;

class UserTest extends PHPUnit_Framework_TestCase {

    public $config;
    public $token;

    public function __construct()
    {
        $this->config = require_once __DIR__. '/../echosign-auth.php';
        $this->token = m::mock('Echosign\Token');
        $this->token->shouldReceive('getAccessToken')->andReturn('12345abc');
    }

    public function testGet()
    {
        $returnJson = '{
          "userInfoList": [
            {
              "company": "Specific Performance, LLC",
              "email": "kenrick@specificperformance.com",
              "fullNameOrEmail": "Kenrick Buchanan",
              "groupId": "2AAABLblqZhAxtQfJjDmP2rfRiL_sT83WVNLSS_ZrcOw6UQNbfYYZn9HSluHuA1x63UT41eFNAYI*",
              "userId": "2AAABLblqZhAKeyuN406fXRj1LowesdnhuXS_c8mxjpby3X9p-NXY_NWXq4RAoMKWqVtElqjA5gk*"
            }
          ]
        }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( json_decode( $returnJson, true) );

        $user = new \Echosign\User($this->token);
        $user->setTransport($transport);

        $usersInfo = $user->get();
        $this->assertInstanceOf('Echosign\Responses\UsersInfo', $usersInfo);
        $userList = $usersInfo->getUserInfoList();
        $firstUser = $userList[0];

        $this->assertEquals("Specific Performance, LLC", $firstUser->getCompany());
        $this->assertEquals("kenrick@specificperformance.com", $firstUser->getEmail());
        $this->assertEquals("Kenrick Buchanan", $firstUser->getFullNameOrEmail());
        $this->assertEquals("2AAABLblqZhAxtQfJjDmP2rfRiL_sT83WVNLSS_ZrcOw6UQNbfYYZn9HSluHuA1x63UT41eFNAYI*", $firstUser->getGroupId());
        $this->assertEquals("2AAABLblqZhAKeyuN406fXRj1LowesdnhuXS_c8mxjpby3X9p-NXY_NWXq4RAoMKWqVtElqjA5gk*", $firstUser->getUserId());
    }

    public function testCreate()
    {
        $returnJson = '{
              "result": "SUCCESS"
        }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('post')->andReturn( json_decode( $returnJson, true) );

        $user = new \Echosign\User($this->token);
        $user->setTransport($transport);

        $userCreationInfo = new \Echosign\Info\UserCreationInfo('jon','stamos','test@test.com','123balls','2AAABLblqZhAxtQfJjDmP2rfRiL_sT83WVNLSS_ZrcOw6UQNbfYYZn9HSluHuA1x63UT41eFNAYI*');

        $created = $user->create($userCreationInfo);

        $this->assertTrue( $created );
    }
}