<?php namespace frontend\tests\acceptance;
use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class LoginCest
{
    public function checkLogin(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('My Application');
        $I->seeLink('Login');
        $I->wait(1);
        $I->click('Login');
        $I->wait(1); // wait for page to be opened
        $I->fillField('LoginForm[username]', 'user123');
        $I->wait(1); // wait for page to be opened
        $I->fillField('LoginForm[password]', 'user123');
        $I->wait(1); // wait for page to be opened
        $I->submitForm('#login-form', array('user' => array(
            'LoginForm[username]' => 'user123',
            'LoginForm[password]' => 'user123',
        )), 'login-button');
        $I->wait(5); // wait for page to be opened
        $I->amOnPage(Url::toRoute('/site/about'));
        $I->wait(5);


    }
}
