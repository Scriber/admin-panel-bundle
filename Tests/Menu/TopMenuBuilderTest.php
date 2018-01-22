<?php
namespace Scriber\Bundle\AdminPanelBundle\Tests\Menu;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Rzeka\Menu\MenuItemInterface;
use Scriber\Bundle\AdminPanelBundle\Event\TopMenuBuildEvent;
use Scriber\Bundle\AdminPanelBundle\Event\TopMenuFinishBuildEvent;
use Scriber\Bundle\AdminPanelBundle\Menu\TopMenuBuilder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TopMenuBuilderTest extends TestCase
{
    public function testGetName()
    {
        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $builder = new TopMenuBuilder($dispatcher);

        static::assertEquals('scriber_admin_panel.top', $builder->getName());
    }

    public function testBuild()
    {
        /** @var EventDispatcherInterface|MockObject $dispatcher */
        $dispatcher = $this->createMock(EventDispatcherInterface::class);

        $dispatcher
            ->expects(static::exactly(2))
            ->method('dispatch')
            ->withConsecutive(
                [TopMenuBuildEvent::class, static::isInstanceOf(TopMenuBuildEvent::class)],
                [TopMenuFinishBuildEvent::class, static::isInstanceOf(TopMenuFinishBuildEvent::class)]
            );

        $builder = new TopMenuBuilder($dispatcher);
        $result = $builder->build();

        static::assertInstanceOf(MenuItemInterface::class, $result);
        static::assertEquals('scriber_admin_panel.top', $result->getTitle());
    }
}
