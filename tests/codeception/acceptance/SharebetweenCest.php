<?php

namespace humhub\modules\sharebetween\codeceptionTest\acceptance;

use sharebetween\AcceptanceTester;

class SharebetweenCest
{

    public function testShareContentBetweenSpaces(AcceptanceTester $I)
    {
        $I->wantTo('share a content between spaces');
        $I->amAdmin();
        $I->amOnSpace1();

        $I->amGoingTo('share a public post');
        $I->waitForText('Post Public', null, $this->getWallEntrySelector(1));
        $I->see('Share', $this->getAddonsSelector(1));
        $I->click('Share', $this->getAddonsSelector(1));

        $I->waitForText('Share content', null, '#globalModal');
        $I->selectFromPicker('#globalModal #shareform-spaces', 'Space 2');
        $I->click('Save', '#globalModal');
        $I->waitForText('Share (1)', null, $this->getAddonsSelector(1));

        $I->amGoingTo('check the post has been shared on the Space 2');
        $I->amOnSpace2();
        $I->waitForText('Admin Tester shared a post @ Space 1', null, $this->getWallEntrySelector(1));
    }

    public function testShareContentToProfile(AcceptanceTester $I)
    {
        $I->wantTo('share a content to profile');
        $I->amAdmin();
        $I->amOnSpace1();

        $I->amGoingTo('share a post to profile');
        $I->waitForText('Post Public', null, $this->getWallEntrySelector(1));
        $I->see('Share', $this->getAddonsSelector(1));
        $I->click('Share', $this->getAddonsSelector(1));

        $I->waitForText('Share content', null, '#globalModal');
        $I->see('Share this content on your profile stream');
        $I->checkOption('#shareform-onprofile');
        $I->click('Save', '#globalModal');
        $I->waitForText('Share (1)', null, $this->getAddonsSelector(1));

        $I->amGoingTo('check the post has been shared on profile page');
        $I->amOnProfile();
        $I->waitForText('Admin Tester shared a post @ Space 1', null, $this->getWallEntrySelector(1));
    }

    public function testShareContentBetweenSpacesAndProfile(AcceptanceTester $I)
    {
        $I->wantTo('share a content between spaces');
        $I->amAdmin();
        $I->amOnSpace1();

        $I->amGoingTo('share a public post');
        $I->waitForText('Post Public', null, $this->getWallEntrySelector(1));
        $I->see('Share', $this->getAddonsSelector(1));
        $I->click('Share', $this->getAddonsSelector(1));

        $I->waitForText('Share content', null, '#globalModal');
        $I->selectFromPicker('#globalModal #shareform-spaces', 'Space 2');
        $I->selectFromPicker('#globalModal #shareform-spaces', 'Space 3');
        $I->see('Share this content on your profile stream');
        $I->checkOption('#shareform-onprofile');
        $I->click('Save', '#globalModal');
        $I->waitForText('Share (3)', null, $this->getAddonsSelector(1));

        $I->amGoingTo('check the post has been shared on the Space 2');
        $I->amOnSpace2();
        $I->waitForText('Admin Tester shared a post @ Space 1', null, $this->getWallEntrySelector(1));

        $I->amGoingTo('check the post has been shared on the Space 3');
        $I->amOnSpace3();
        $I->waitForText('Admin Tester shared a post @ Space 1', null, $this->getWallEntrySelector(1));

        $I->amGoingTo('check the post has been shared on profile page');
        $I->amOnProfile();
        $I->waitForText('Admin Tester shared a post @ Space 1', null, $this->getWallEntrySelector(1));
    }

    public function testSharePrivateContent(AcceptanceTester $I)
    {
        $I->wantTo('private content cannot be shared');
        $I->amAdmin();
        $I->amOnSpace1();

        $I->amGoingTo('try to share a private post');
        $I->amOnSpace1();
        $I->waitForText('Post Private', null, $this->getWallEntrySelector(2));
        $I->dontSee('Share', $this->getAddonsSelector(2));
    }

    private function getWallEntrySelector(int $index): string
    {
        return '.s2_streamContent > [data-stream-entry]:nth-of-type(' . $index . ')';
    }

    private function getAddonsSelector(int $index): string
    {
        return $this->getWallEntrySelector($index) . ' .stream-entry-addons';
    }

}