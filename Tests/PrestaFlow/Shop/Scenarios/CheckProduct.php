<?php

namespace Tests\PrestaFlow\Shop\Scenarios;

use PrestaFlow\Library\Expects\Expect;
use PrestaFlow\Library\Scenarios\Scenario;

class CheckProduct extends Scenario
{
    public function steps($testSuite)
    {
        $this->importPage('FrontOffice\Category');
        $this->importPage('FrontOffice\Product');
        extract($this->pages);

        $testSuite
        ->it('should go to page', function () use ($frontOfficeCategoryPage) {
            $frontOfficeCategoryPage->goToPage($frontOfficeCategoryPage, $this->getParam('categoryId'));

            $pageTitle = $frontOfficeCategoryPage->getPageTitle();

            Expect::that($pageTitle)->contains($this->getParam('categoryName'));
        })
        ->it('should go to product page from category page', function () use ($frontOfficeCategoryPage, $frontOfficeProductPage) {
            $frontOfficeCategoryPage->goToProduct($this->getParam('productIndex'));

            $productTitle = $frontOfficeProductPage->getTitle();

            Expect::that($productTitle)->equals(
                $this->getParam('productName'),
                'Product title should be correct'
            );
        })
        ;

        return $testSuite;
    }
}
