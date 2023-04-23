<?php

namespace Tests\app\Infrastructure\Controller;
use App\Application\UserDataSource\UserDataSource;
use Tests\TestCase;
use App\Domain\User;


class GetApiControllerTest extends TestCase
{
    private UserDataSource $userdata;
    /**
     * @setUp
     */
    protected function setUp():void
    {
        parent::setUp();
        $this->userdata = \Mockery::mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, function () {
            return $this->userdata;
        });
    }
    /**
     * @test
     */
    public function userWithGivenEmailDoesNotExist(){
        $this->userdata
            ->expects('findByEmail')
            ->with('email@email.com')
            ->andReturnNull();
        $response = $this->get('/api/user/early-adopter/email@email.com');
        $response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }
    /**
     * @test
     */
    public function userWithGivenEmailDoesExistWithIdHigherThan1000(){
        $this->userdata
            ->expects('findByEmail')
            ->with('email@email.com')
            ->andReturn(new User(1005, "email@email.com"));
        $response = $this->get('/api/user/early-adopter/email@email.com');
        $response->assertExactJson(['El usuario no es early adopter']);
    }
    /**
     * @test
     */
    public function userWithGivenEmailDoesExistWithIdLowerThan1000(){
        $this->userdata
            ->expects('findByEmail')
            ->with('email@email.com')
            ->andReturn(new User(10, "email@email.com"));
        $response = $this->get('/api/user/early-adopter/email@email.com');
        $response->assertExactJson(['El usuario es early adopter']);
    }
}
