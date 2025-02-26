<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Application\Services\AuthService;
use App\Domain\Repositories\SuperAdminRepositoryInterface;
use App\Domain\Entities\SuperAdministrateur;
use App\Models\SuperAdminModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\SendOtpMail;
use Illuminate\Http\Response;
use Exception;

class AuthServiceTest extends TestCase
{
    private $repositoryMock;
    private $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repositoryMock = Mockery::mock(SuperAdminRepositoryInterface::class);
        $this->authService = new AuthService($this->repositoryMock);
    }

    public function test_register_creates_user()
    {
        $data = [
            'email' => 'test@example.com',
            'password' => 'password123',
            'fonction' => 'SuperAdmin',
            'nom' => 'Test',
            'telephone' => '123456789',
            'poste_de_travail' => 'Admin'
        ];

        $superAdmin = new SuperAdministrateur(
            id: null,
            nom: $data['nom'],
            postnom: null,
            prenom: null,
            telephone: $data['telephone'],
            email: $data['email'],
            fonction: $data['fonction'],
            poste_de_travail: $data['poste_de_travail'],
            nbr_egopass_desactiver: null,
            password: Hash::make($data['password']),
            created_at: null,
            updated_at: null
        );

        $this->repositoryMock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($input) use ($data) {
                return $input['email'] === $data['email'] && Hash::check($data['password'], $input['password']);
            }))
            ->andReturn($superAdmin);

        $result = $this->authService->register($data);

        $this->assertInstanceOf(SuperAdministrateur::class, $result);
        $this->assertEquals($data['email'], $result->email);
        $this->assertTrue(Hash::check($data['password'], $result->password));
    }

    public function test_login_with_correct_credentials_returns_user_and_token()
    {
        $credentials = ['email' => 'admin@example.com', 'password' => 'password123'];
        $hashedPassword = Hash::make($credentials['password']);
        
        $superAdmin = Mockery::mock(SuperAdminModel::class);
        $superAdmin->shouldReceive('getAttribute')->with('email')->andReturn($credentials['email']);
        $superAdmin->shouldReceive('getAttribute')->with('password')->andReturn($hashedPassword);
        $superAdmin->shouldReceive('getAttribute')->with('fonction')->andReturn('SuperAdmin');
        $superAdmin->shouldReceive('createToken')->andReturn((object)['plainTextToken' => 'mock_token']);
        
        $this->repositoryMock->shouldReceive('findByEmail')
            ->once()
            ->with($credentials['email'])
            ->andReturn($superAdmin);
        
        $result = $this->authService->login($credentials);
        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('token', $result);
    }

    public function test_login_fails_when_user_not_found()
    {
        $credentials = ['email' => 'test@example.com', 'password' => 'password123'];

        $this->repositoryMock->shouldReceive('findByEmail')
            ->once()
            ->with($credentials['email'])
            ->andReturn(null);

        $result = $this->authService->login($credentials);

        $this->assertEquals('Supper admin non trouvé', $result['error']);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $result['status']);
    }

    public function test_request_reset_password_sends_otp_email()
    {
        Mail::fake();
        Cache::shouldReceive('put')->once();
        
        $identifier = 'admin@example.com';
        $user = Mockery::mock(SuperAdministrateur::class);
        
        $this->repositoryMock->shouldReceive('findByEmailOrPhone')
            ->once()
            ->with($identifier)
            ->andReturn($user);
        
        $this->authService->requestResetPassword($identifier);
        
        Mail::assertSent(SendOtpMail::class);
    }

    public function test_request_reset_password_throws_exception_when_user_not_found()
    {
        $identifier = 'unknown@example.com';

        $this->repositoryMock->shouldReceive('findByEmailOrPhone')
            ->once()
            ->with($identifier)
            ->andReturn(null);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Supper admin  non trouvé');

        $this->authService->requestResetPassword($identifier);
    }

    public function test_verify_otp_success()
    {
        Cache::shouldReceive('get')->once()->andReturn(123456);
        Cache::shouldReceive('forget')->once();

        $result = $this->authService->verifyOtp('test@example.com', 123456);

        $this->assertTrue($result);
    }

    public function test_verify_otp_fails()
    {
        Cache::shouldReceive('get')->once()->andReturn(null);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Code OTP invalide ou expiré');

        $this->authService->verifyOtp('test@example.com', 123456);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
