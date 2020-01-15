<?php
namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('My Application');
        $I->seeLink('About');
        $I->wait(2);
        $I->click('About');
        $I->see('This is the About page.');
        $I->wait(2); // wait for page to be opened
        $I->click('Contact');
        $I->wait(2);
        $I->fillField('ContactForm[name]', 'Pupkin');
        $I->wait(2);
    }
}
