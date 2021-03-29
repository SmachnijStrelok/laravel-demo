<?php

namespace Tests\Integration;

use App\Http\Requests\Api\Chat\CreateChatToComplaintRequest;
use App\Http\Services\ChatService;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\MockObject\MockBuilder;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {

    }
}
