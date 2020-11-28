<?php

$hostname = app(Hyn\Tenancy\Contracts\CurrentHostname::class);

if($hostname) {
    Route::domain($hostname->fqdn)->group(function () {
        Route::middleware(['auth', 'locked.tenant'])->group(function() {


            Route::get('categories', 'CategoryController@index')->name('tenant.categories.index')->middleware('redirect.level');
            Route::get('categories/records', 'CategoryController@records');
            Route::get('categories/columns', 'CategoryController@columns');
            Route::get('categories/record/{category}', 'CategoryController@record');
            Route::post('categories', 'CategoryController@store');
            Route::delete('categories/{category}', 'CategoryController@destroy');

            Route::get('laboratorios', 'LaboratorioController@index')->name('tenant.laboratorios.index')->middleware('redirect.level');/*achonto*/
            Route::get('laboratorios/records', 'LaboratorioController@records');/*achonto*/
            Route::get('laboratorios/columns', 'LaboratorioController@columns');/*achonto*/
            Route::get('laboratorios/record/{laboratorio}', 'LaboratorioController@record');/*achonto*/
            Route::post('laboratorios', 'LaboratorioController@store');/*achonto*/
            Route::delete('laboratorios/{laboratorio}', 'LaboratorioController@destroy');/*achonto*/

            Route::get('indicaciones', 'IndicacionController@index')->name('tenant.indicaciones.index')->middleware('redirect.level');/*achonto*/
            Route::get('indicaciones/records', 'IndicacionController@records');/*achonto*/
            Route::get('indicaciones/columns', 'IndicacionController@columns');/*achonto*/
            Route::get('indicaciones/record/{indicacion}', 'IndicacionController@record');/*achonto*/
            Route::post('indicaciones', 'IndicacionController@store');/*achonto*/
            Route::delete('indicaciones/{indicacion}', 'IndicacionController@destroy');/*achonto*/

            Route::get('presentaciones', 'PresentacionController@index')->name('tenant.presentaciones.index')->middleware('redirect.level');/*achonto*/
            Route::get('presentaciones/records', 'PresentacionController@records');/*achonto*/
            Route::get('presentaciones/columns', 'PresentacionController@columns');/*achonto*/
            Route::get('presentaciones/record/{presentacion}', 'PresentacionController@record');/*achonto*/
            Route::post('presentaciones', 'PresentacionController@store');/*achonto*/
            Route::delete('presentaciones/{presentacion}', 'PresentacionController@destroy');/*achonto*/

            Route::get('brands', 'BrandController@index')->name('tenant.brands.index')->middleware('redirect.level');
            Route::get('brands/records', 'BrandController@records');
            Route::get('brands/record/{brand}', 'BrandController@record');
            Route::post('brands', 'BrandController@store');
            Route::get('brands/columns', 'BrandController@columns');
            Route::delete('brands/{brand}', 'BrandController@destroy');

            Route::get('incentives', 'IncentiveController@index')->name('tenant.incentives.index')->middleware('redirect.level');
            Route::get('incentives/records', 'IncentiveController@records');
            Route::get('incentives/record/{incentive}', 'IncentiveController@record');
            Route::post('incentives', 'IncentiveController@store');
            Route::get('incentives/columns', 'IncentiveController@columns');
            Route::delete('incentives/{incentive}', 'IncentiveController@destroy');

            Route::get('items/barcode/{item}', 'ItemController@generateBarcode');

            Route::post('items/import/item-price-lists', 'ItemController@importItemPriceLists');

            Route::prefix('item-lots')->group(function () {
                
                Route::get('', 'ItemLotController@index')->name('tenant.item-lots.index');
                Route::get('/records', 'ItemLotController@records');
                Route::get('/record/{record}', 'ItemLotController@record');
                Route::post('', 'ItemLotController@store');
                Route::get('/columns', 'ItemLotController@columns');
                Route::get('/export', 'ItemLotController@export');

            });

            Route::post('items/import/item-sets', 'ItemSetController@importItemSets');
            Route::post('items/import/item-sets-individual', 'ItemSetController@importItemSetsIndividual');


            Route::prefix('web-platforms')->group(function () {
                
                Route::get('', 'WebPlatformController@index');
                Route::get('/records', 'WebPlatformController@records');
                Route::get('/record/{brand}', 'WebPlatformController@record');
                Route::post('', 'WebPlatformController@store');
                Route::delete('/{record}', 'WebPlatformController@destroy');

            });


        });
    });
}
