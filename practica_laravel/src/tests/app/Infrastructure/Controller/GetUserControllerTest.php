<?php


namespace Tests\app\Infrastructure\Controller;
use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Tests\TestCase;

class GetUserControllerTest extends TestCase
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
            //->never();
            ->with('email@email.com')
            ->andReturnNull();
        $response = $this->get('/api/user/email@email.com');
        $response->assertNotFound();
        $response->assertExactJson(['error'=>'usuario no encontrado']);
    }
   /* public function userWithGivenEmailDoesNotExist(){
        $response = $this->get('/api/user/email@email.com');
        $response->assertNotFound();
        $response->assertExactJson(['error'=>'usuario no encontrado']);
    }*/
    /**
     * @test
     */
    public function userWithGivenEmailDoesExist(){
        $this->userdata
            ->expects('findByEmail')
            ->with('email@email.com')
            ->andReturn(new User(1, "email@email.com"));
        $response = $this->get('/api/user/email@email.com');
        $response->assertExactJson(['id' => '1', 'email' => 'email@email.com']);
    }
}
