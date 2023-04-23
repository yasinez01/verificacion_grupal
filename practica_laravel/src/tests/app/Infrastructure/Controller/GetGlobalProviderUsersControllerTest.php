<?php


namespace Tests\app\Infrastructure\Controller;
use App\Application\UserDataSource\UserDataSource;
use Tests\TestCase;
use App\Domain\User;

class GetGlobalProviderUsersControllerTest extends TestCase
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
    public function ListOfSpecialUsersWithoutAGlobalEmail(){
        $this->usersdata
            ->expects('getAll')
            ->andReturn([new User(1, "email@email.com"),new User(3,"email2@email.com")]);
        $response = $this->get('/api/global-provider-users');
        $response->assertExactJson([]);
    }
    /**
     * @test
     */
    public function ListOfSpecialUsersWithAGlobalEmail(){
        $this->usersdata
            ->expects('getAll')
            ->andReturn([new User(2, "another_email@email.com"),new User(5, "another_email2@gmail.com")]);
        $response = $this->get('/api/global-provider-users');
        $response->assertExactJson([['id' => '1', 'email' => 'email@gmail.com'],['id' => '2', 'email' => 'otro_email@hotmail.com']]);
    }
}
