<?php

namespace Tests\PrestaFlow\Shop\Pages\v9\Front\GuestTracking;

use PrestaFlow\Library\Pages\Common\FrontOffice\Page as BasePage;

class Page extends BasePage
{
    public string $url = 'guest-tracking';
    public string $pageTitle = 'Guest Order Tracking';

    public function defineSelectors()
    {
        return [
            'orderReference' => 'input[name="order_reference"]',
            'email' => 'input[name="email"]',
            'submitButton' => 'button[type="submit"]',
            'notificationMessage' => '.notifications-container article ul li'
        ];
    }

    public function defineMessages()
    {
        return [
            'missingData' => $this->translate('Please provide the required information'),
            'orderNotFound' => $this->translate('We couldn\'t find your order with the information provided, please try again'),
            'followOrderTitle' => $this->translate('Guest Tracking')
        ];
    }

    public function submitForm(string $orderReference = '', string $email = '')
    {
        $this->setValue($this->selector('orderReference'), $orderReference);
        $this->setValue($this->selector('email'), $email);
        $this->click($this->selector('submitButton'));

        $this->getPage()->waitForReload();

        if ($this->isVisible($this->selector('notificationMessage')) !== false) {
            return $this->getTextContent($this->selector('notificationMessage'));
        }

        return $this->getPageTitle();
    }
}
