<?php


namespace Tests\app\Infrastructure\Controller;
use App\Application\UserDataSource\UserDataSource;
use Tests\TestCase;
use App\Domain\User;

class GetUsersControllerTest extends TestCase
{
    private UserDataSource $usersdata;
    /**
     * @setUp
     */
    protected function setUp():void
    {
        parent::setUp();
        $this->usersdata = \Mockery::mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, function () {
            return $this->usersdata;
        });
    }

    /**
     * @test
     */
    public function ListOfUsersEmpty(){
        $this->usersdata
            ->expects('getAll')
            ->andReturnNull();
        $response = $this->get('/api/users');
        $response->assertExactJson([]);
    }
    /**
     * @test
     */
    public function ListOfUsersNotEmpty(){
        $this->usersdata
            ->expects('getAll')
            ->andReturn([new User(1, "email@email.com"), new User(2, "another_email@email.com")]);
        $response = $this->get('/api/users');
        $response->assertExactJson([['id' => '1', 'email' => 'email@email.com'],['id' => '2', 'email' => 'another_email@email.com']]);
    }
}
