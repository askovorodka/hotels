<?php

class HotelCategoryCest
{
    protected function _before(ApiTester $I)
    {
    }

    protected function _after(ApiTester $I)
    {
    }

    /**
     * @param ApiTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function tryGetHotelCategories(ApiTester $I)
    {
        $I->loginAsTester();
        $I->checkGetEntity('/api/v3/hotel-categories');
    }
}