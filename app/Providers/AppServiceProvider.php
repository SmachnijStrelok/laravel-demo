<?php

namespace App\Providers;

use App\Http\Components\Department\Repositories\DepartmentRepository;
use App\Http\Components\Department\Repositories\IDepartmentRepository;
use App\Http\Components\Settings\Repositories\ActualSettingRepository;
use App\Http\Components\Settings\Repositories\Contracts\IActualSettingRepository;
use App\Http\Components\Settings\Repositories\Contracts\ISettingRepository;
use App\Http\Components\Settings\Repositories\SettingRepository;
use App\Http\Components\Settings\Setting;
use App\Http\Components\Settings\UseCase\ISetting;
use App\Http\Components\User\Repositories\Contracts\IDepartmentToUsersRepository;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\Repositories\Contracts\IUserTokenRepository;
use App\Http\Components\User\Repositories\DepartmentToUserRepository;
use App\Http\Components\User\Repositories\UserConfirmationRepository;
use App\Http\Components\User\Repositories\UserRepository;
use App\Http\Components\User\Repositories\UserTokenRepository;
use App\Http\Services\Uploader\FileUploader;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IUserTokenRepository::class, UserTokenRepository::class);
        $this->app->bind(IUserConfirmationRepository::class, UserConfirmationRepository::class);
        $this->app->bind(IActualSettingRepository::class, ActualSettingRepository::class);
        $this->app->bind(ISettingRepository::class, SettingRepository::class);
        $this->app->bind(IDepartmentRepository::class, DepartmentRepository::class);
        $this->app->bind(IDepartmentToUsersRepository::class, DepartmentToUserRepository::class);

        $publicStorage = Storage::disk('public');
        $fileUploader = new FileUploader($publicStorage, $this->app->request);
        $this->app->instance(FileUploader::class, $fileUploader);

        $this->app->singleton(ISetting::class, Setting::class);

        JsonResource::withoutWrapping();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
