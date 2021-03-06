<?php

declare(strict_types=1);

namespace spec\Gweb\SyliusProductDepositPlugin\Menu;

use Gweb\SyliusProductDepositPlugin\Menu\AdminProductVariantFormMenuListener;
use Knp\Menu\ItemInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\AdminBundle\Event\ProductVariantMenuBuilderEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

final class AdminProductVariantFormMenuListenerSpec extends ObjectBehavior
{
    function let(
        TranslatorInterface $translator
    ): void {
        $translator->trans('gweb_deposit.admin.product_variant.menu')->willReturn('Deposit');

        $this->beConstructedWith($translator);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AdminProductVariantFormMenuListener::class);
    }

    function it_build_menu(
        ProductVariantMenuBuilderEvent $menuBuilderEvent,
        ItemInterface $menuItem,
        ItemInterface $rootMenuItem
    ): void {
        $menuBuilderEvent->getMenu()->willReturn($rootMenuItem);
        $rootMenuItem->addChild('deposit', ['position' => 1])->willReturn($menuItem);

        $menuItem->setAttribute(
            'template',
            '@GwebSyliusProductDepositPlugin/Resources/views/Admin/ProductVariant/Tab/_deposit.html.twig'
        )->willReturn($menuItem);
        $menuItem->setLabel('Deposit')->willReturn($menuItem);
        $menuItem->setLabelAttribute('icon', 'dollar')->shouldBeCalled();

        $this->addItems($menuBuilderEvent);
    }
}
