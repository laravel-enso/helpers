<?php

require_once __DIR__.'/../Fixtures/FactoryResolverFixtures.php';

use LaravelEnso\Helpers\Services\FactoryResolver;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FactoryResolverTest extends TestCase
{
    #[Test]
    public function resolves_local_factories_before_package_factories()
    {
        $resolver = new FactoryResolver();

        $this->assertSame(
            'Database\\Factories\\HelpersResolverLocalModelFactory',
            $resolver(App\Models\HelpersResolverLocalModel::class)
        );
    }

    #[Test]
    public function resolves_package_factories_when_no_local_factory_exists()
    {
        $resolver = new FactoryResolver();

        $this->assertSame(
            Vendor\Package\Database\Factories\WidgetFactory::class,
            $resolver(Vendor\Package\Models\Widget::class)
        );
    }

    #[Test]
    public function returns_null_when_no_factory_can_be_resolved()
    {
        $resolver = new FactoryResolver();

        $this->assertNull($resolver(HelpersMissingFactoryModel::class));
    }
}
