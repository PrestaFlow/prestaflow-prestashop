<?php

namespace Tests\PrestaFlow;

use PrestaFlow\Library\Expects\Expect;
use PrestaFlow\Library\Tests\TestsSuite;

class Tutorial extends TestsSuite
{
    public function init()
    {
        $this->importPage('Front\GuestTracking', domain: 'Tests\PrestaFlow\Shop');
        $this->importPage('BackOffice\Login');
        $this->importPage('BackOffice\Dashboard');
        $this->importPage('BackOffice\Customer');

        extract($this->pages);

        $this
            ->describe('PrestaFlow: tutorial test suite')
            ->skipWhenFailed(false)
            ->it('go to order tracking page', function() use ($frontGuestTrackingPage) {
                $frontGuestTrackingPage->goToPage();

                $pageTitle = $frontGuestTrackingPage->getPageTitle();

                Expect::that($pageTitle)->equals($frontGuestTrackingPage->pageTitle());
            })
            /*
            ->skip('submit empty order tracking form', function() use ($frontGuestTrackingPage) {
                $submitMessage = $frontGuestTrackingPage->submitForm('QIIXJXNUI');

                Expect::that($submitMessage)->equals(
                    $frontGuestTrackingPage->getMessage('missingData')
                );
            })
            ->skip('submit form with bad datas', function() use ($frontGuestTrackingPage) {
                $submitMessage = $frontGuestTrackingPage->submitForm('QIIXJXNUI', 'pub@prestashop.com');

                Expect::that($submitMessage)->equals(
                    $frontGuestTrackingPage->getMessage('orderNotFound')
                );
            })
                */
            ->it('submit form with good datas', function() use ($frontGuestTrackingPage) {
                $submitMessage = $frontGuestTrackingPage->submitForm('KHWLILZLL', 'pub@prestashop.com');

                Expect::that($submitMessage)->equals(
                    $frontGuestTrackingPage->getMessage('followOrderTitle')
                );
            })
            ->it('should login into BO with default user', function () use ($backOfficeLoginPage, $backOfficeDashboardPage) {
                // Avoid this line : only there cause the DELETE raw key doesn't work as now
                $backOfficeLoginPage->goToPage();
                $backOfficeLoginPage->login();

                Expect::that($backOfficeDashboardPage->getPageTitle())->contains($backOfficeDashboardPage->pageTitle());
            })
            ->it('should change customer e-mail', function () use ($backOfficeCustomerPage) {
                $backOfficeCustomerPage->goToPage('sell/customers/{id}/edit', ['id' => 2]);

                $backOfficeCustomerPage->setValue($backOfficeCustomerPage->getSelector('emailInput'), 'newemail@example.com');
                $backOfficeCustomerPage->click($backOfficeCustomerPage->getSelector('saveButton'));
                $backOfficeCustomerPage->waitForPageReload();
            })
            ->it('submit form with good datas', function() use ($frontGuestTrackingPage) {
                $submitMessage = $frontGuestTrackingPage->submitForm('KHWLILZLL', 'pub@prestashop.com');

                Expect::that($submitMessage)->equals(
                    $frontGuestTrackingPage->getMessage('followOrderTitle')
                );
            })
            ->it('should change customer e-mail', function () use ($backOfficeCustomerPage) {
                $backOfficeCustomerPage->goToPage('sell/customers/{id}/edit', ['id' => 2]);

                $backOfficeCustomerPage->setValue($backOfficeCustomerPage->getSelector('emailInput'), 'pub@prestashop.com');
                $backOfficeCustomerPage->click($backOfficeCustomerPage->getSelector('saveButton'));
                $backOfficeCustomerPage->waitForPageReload();
            })
            ->it('should log out from BO', function () use ($backOfficeLoginPage) {
                $backOfficeLoginPage->logout();
            });
        ;
    }
}
