<?php

/*
 * This file is part of the AdminLTE bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KevinPapst\AdminLTEBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges the AdminLTEBundle configuration
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('admin_lte');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->append($this->getOptionsConfig())
                ->append($this->getControlSidebarConfig())
                ->append($this->getThemeConfig())
                ->append($this->getKnpMenuConfig())
                ->append($this->getRouteAliasesConfig())
            ->end()
        ->end();

        return $treeBuilder;
    }

    private function getRouteAliasesConfig()
    {
        $treeBuilder = new TreeBuilder('routes');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('adminlte_welcome')
                    ->defaultValue('home')
                    ->info('name of the homepage route')
                ->end()
                ->scalarNode('adminlte_login')
                    ->defaultValue('login')
                    ->info('name of the form login route')
                ->end()
                ->scalarNode('adminlte_login_check')
                    ->defaultValue('login_check')
                    ->info('name of the form login_check route')
                ->end()
                ->scalarNode('adminlte_registration')
                    ->defaultNull()
                    ->info('name of the user registration form route')
                ->end()
                ->scalarNode('adminlte_password_reset')
                    ->defaultNull()
                    ->info('name of the forgot-password form route')
                ->end()
                ->scalarNode('adminlte_message')
                    ->defaultValue('message')
                    ->info('name of the route to one message')
                ->end()
                ->scalarNode('adminlte_messages')
                    ->defaultValue('messages')
                    ->info('name of the route to all messages')
                ->end()
                ->scalarNode('adminlte_notification')
                    ->defaultValue('notification')
                    ->info('name of the route to one notification')
                ->end()
                ->scalarNode('adminlte_notifications')
                    ->defaultValue('notifications')
                    ->info('name of the route to all notification')
                ->end()
                ->scalarNode('adminlte_task')
                    ->defaultValue('task')
                    ->info('name of the route to one task')
                ->end()
                ->scalarNode('adminlte_tasks')
                    ->defaultValue('tasks')
                    ->info('name of the route to all tasks')
                ->end()
                ->scalarNode('adminlte_profile')
                    ->defaultValue('profile')
                    ->info('name of the route to the users profile')
                ->end()
            ->end()
        ->end();

        return $rootNode;
    }

    private function getKnpMenuConfig()
    {
        $treeBuilder = new TreeBuilder('knp_menu');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enable')
                    ->defaultFalse()
                    ->info('')
                ->end()
                ->scalarNode('main_menu')
                    ->defaultValue('adminlte_main')
                    ->info('your builder alias')
                ->end()
                ->scalarNode('breadcrumb_menu')
                    ->defaultFalse()
                    ->info('Your builder alias or false to disable breadcrumbs')
                ->end()
            ->end()
        ->end();

        return $rootNode;
    }

    private function getWidgetConfig()
    {
        $treeBuilder = new TreeBuilder('widget');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('collapsible_title')
                    ->defaultValue('Collapse')
                    ->info('')
                ->end()
                ->scalarNode('removable_title')
                    ->defaultValue('Remove')
                    ->info('')
                ->end()
                ->scalarNode('type')
                    ->defaultValue('primary')
                    ->info('')
                ->end()
                ->booleanNode('collapsible')
                    ->defaultFalse()
                    ->info('')
                ->end()
                ->booleanNode('removable')
                    ->defaultFalse()
                    ->info('')
                ->end()
                ->booleanNode('solid')
                    ->defaultFalse()
                    ->info('')
                ->end()
            ->end()
        ->end();

        return $rootNode;
    }

    private function getButtonConfig()
    {
        $treeBuilder = new TreeBuilder('button');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('type')
                    ->defaultValue('primary')
                    ->info('default button type')
                ->end()
                ->scalarNode('size')
                    ->defaultFalse()
                    ->info('default button size')
                ->end()
            ->end()
        ->end();

        return $rootNode;
    }

    private function getThemeConfig()
    {
        $treeBuilder = new TreeBuilder('theme');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->append($this->getWidgetConfig())
                ->append($this->getButtonConfig())
            ->end()
        ->end();

        return $rootNode;
    }

    private function getOptionsConfig()
    {
        $treeBuilder = new TreeBuilder('options');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('default_avatar')
                    ->defaultValue('bundles/adminlte/images/default_avatar.png')
                ->end()
                ->scalarNode('default_brand_logo')
                    ->defaultValue('bundles/adminlte/images/adminltelogo.png')
                ->end()
                ->scalarNode('skin')
                    ->defaultValue('skin-blue')
                    ->info('see skin listing for viable options')
                ->end()
                ->scalarNode('navbar_color')
                ->defaultValue('dark')
                ->info('see color variations for viable options')
                ->end()
                ->scalarNode('sidebar_color')
                ->defaultValue('dark-primary')
                ->info('see color variations for viable options')
                ->end()
                ->scalarNode('form_theme')
                    ->defaultValue('default')
                    ->info('the form theme, must be one of: default, horizontal or null')
                    ->validate()
                        ->ifTrue(function ($value) {
                            if (null === $value) {
                                return false;
                            }

                            return !in_array($value, ['default', 'horizontal']);
                        })
                        ->thenInvalid('Invalid form_theme. Expected one of: "default", "horizontal" or null')
                    ->end()
                ->end()
                ->booleanNode('fixed_header')
                    ->defaultFalse()
                ->end()
                ->booleanNode('fixed_menu')
                    ->defaultFalse()
                ->end()
                ->booleanNode('fixed_footer')
                    ->defaultFalse()
                ->end()
                ->booleanNode('boxed_layout')
                    ->defaultFalse()
                    ->info('these settings relate directly to the "Layout Options"')
                ->end()
                ->booleanNode('collapsed_sidebar')
                    ->defaultFalse()
                    ->info('described in the documentation')
                ->end()
                ->booleanNode('mini_sidebar')
                    ->defaultTrue()
                    ->info('')
                ->end()
                ->integerNode('max_navbar_notifications')
                    ->defaultValue(10)
                    ->info('Max number of notifications displayed in the notification bar')
                ->end()
                ->integerNode('max_navbar_tasks')
                    ->defaultValue(10)
                    ->info('Max number of tasks displayed in the notification bar')
                ->end()
                ->integerNode('max_navbar_messages')
                    ->defaultValue(10)
                    ->info('Max number of messages displayed in the notification bar')
                ->end()
            ->end()
        ->end();

        return $rootNode;
    }

    private function getControlSidebarConfig()
    {
        $treeBuilder = new TreeBuilder('control_sidebar');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->arrayPrototype()
                ->children()
                    ->scalarNode('icon')->end()
                    ->scalarNode('controller')->end()
                    ->scalarNode('template')->end()
                ->end()
            ->end()
            ->info('controls all panels in the right control_sidebar')
        ->end();

        return $rootNode;
    }
}
