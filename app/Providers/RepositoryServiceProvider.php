<?php

namespace Bdgt\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $resources = [
            'Account',
            'Bill',
            'Category',
            'Goal',
            'Transaction',
        ];

        foreach ($resources as $resource) {
            $this->app->bind(
                'Bdgt\Repositories\Contracts\\' . $resource . 'RepositoryInterface',
                function ($app, $parameters) use ($resource) {
                    $model = reset($parameters);
                    if (!$model) {
                        $model = $app->make('Bdgt\Resources\\' . $resource);
                    }
                    $repositoryPath = '\Bdgt\Repositories\Eloquent\Eloquent' . $resource . 'Repository';
                    return new $repositoryPath($model);
                }
            );
        }
    }
}
