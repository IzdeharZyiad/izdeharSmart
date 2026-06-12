<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Financial\FinancialController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Material\MaterialController;
use App\Http\Controllers\Admin\Pdf\PdfController;
use App\Http\Controllers\Admin\Purchase\ChequeController;
use App\Http\Controllers\Admin\Purchase\InstallmentController;
use App\Http\Controllers\Admin\Purchase\PurchaseController;
use App\Http\Controllers\Admin\Purchase\TransactionController;
use App\Http\Controllers\Admin\Report\ReportsController;
use App\Http\Controllers\Admin\Sale\ChequeSaleController;
use App\Http\Controllers\Admin\Sale\InstallmentSaleController;
use App\Http\Controllers\Admin\Sale\SaleController;
use App\Http\Controllers\Admin\Sale\SaleDetailController;
use App\Http\Controllers\Admin\Sale\TransactionSaleController;
use App\Http\Controllers\Admin\Stock\StockController;
use App\Http\Controllers\Admin\Type\TypeController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/', 'Login')->name('login');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/users', 'Users')->name('users');
        Route::get('/types', 'Types')->name('types');
        Route::get('/dashboard', 'Dashboard')->name('dashboard');
        Route::get('/sellers', 'Sellers')->name('sellers');
        Route::get('/custemers', 'Custemers')->name('custemers');
        Route::get('/purchases', 'Purchases')->name('purchases');
        Route::get('/sales', 'Sales')->name('sales');
        Route::get('/stocks', 'Stocks')->name('stocks');
        Route::get('/financials', 'Financials')->name('financials');
        Route::get('/settings', 'Settings')->name('settings');
        Route::put('/updateSettings', 'UpdateSettings')->name('updateSettings');
        Route::get('/reports', 'Reports')->name('reports');
        Route::get('/rawMaterials', 'RawMaterials')->name('rawMaterials');

        Route::controller(PdfController::class)->group(function () {
            Route::get('/custemerReport', 'CustemerReport')->name('custemerReport');
            Route::get('/custemerName', 'CustemerName')->name('custemerName');
            Route::get('/productNamePdf/{type_id}', 'ProductNamePdf')->name('productNamePdf');
            Route::get('/accountStatmentCustemerPdf/{custemerId}', 'AccountStatmentCustemerPdf')->name('accountStatmentCustemerPdf');
        });
    });
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/forgetPassword', 'ForgetPassword')->name('forgetPassword');
    Route::post('/forgetPassword', 'StoreforgetPassword')->name('storeforgetPassword');
    Route::post('/', 'Login')->name('storeLogin');
    Route::post('/logout', 'Logout')->name('logout');
});

Route::controller(TypeController::class)->prefix('/types')->name('types.')->middleware('auth:admin')->group(function () {
    Route::get('/items/{typeId}', 'Items')->name('items');
    Route::get('items/products/{itemId}', 'Products')->name('items.products');
    Route::get('items/products/productDetails/{itemId}/{productId}', 'productDetails')->name('items.products.productDetails');
    Route::get('/updateProductDetail/{productDetailId}', 'UpdateProductDetail')->name('updateProductDetail');
    Route::put('/updateProductDetail', 'EditeProductDetail')->name('EditeProductDetail');
    Route::get('/recipes/{productDetailId}', 'Recipes')->name('recipes');
    Route::get('/addRecipeDetail/{recipeId}', 'AddRecipeDetail')->name('addRecipeDetail');
    Route::post('/addRecipeDetail', 'StoreRecipeDetail')->name('storeRecipeDetail');
    Route::get('items/products/addProductDetails/{itemId}/{productId}', 'addProductDetails')->name('items.addProductDetails');
    Route::post('items/products/addProductDetails', 'storeProductDetails')->name('items.storeProductDetails');
    Route::get('items/products/editProduct/{productId}', 'editProduct')->name('items.editProduct');
    Route::put('items/products/editProduct', 'updateProduct')->name('items.updateProduct');
});

Route::prefix('/purchases')->name('purchases.')->middleware('auth:admin')->group(function () {
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('/addPurchase', 'AddPurchase')->name('addPurchase');
        Route::get('/purchaseDetails/{purchaseId}', 'PurchaseDetails')->name('purchaseDetails');
        Route::get('/purchaseDetails/addPurchaseDetails/{purchaseId}', 'AddPurchaseDetails')->name('purchaseDetails.addPurchaseDetails');
        Route::post('/addPurchase', 'StorePurchase')->name('storePurchase');
        Route::post('/purchaseDetails/addPurchaseDetails', 'StorePurchaseDetails')->name('purchaseDetails.storePurchaseDetails');
    });
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactionsPurchase/{purchaseId}', 'TransactionsPurchase')->name('transactionsPurchase');
        Route::get('/transactionsPurchase/addTransactionsPurchas/{purchaseId}', 'AddTransactionsPurchas')->name('transactionsPurchase.addTransactionsPurchas');
        Route::post('/transactionsPurchase/addTransactionsPurchas', 'StoreTransactionsPurchas')->name('transactionsPurchase.storeTransactionsPurchas');
        Route::get('/addPurchaseMoney/{purchaseId}', 'AddPurchaseMoney')->name('addPurchaseMoney');
        Route::post('/addPurchaseMoney', 'StorePurchaseMoney')->name('storePurchaseMoney');

        Route::get('/addPurchaseMoneyDis/{purchaseDetailId}', 'AddPurchaseMoneyDis')->name('addPurchaseMoneyDis');
        Route::post('/addPurchaseMoneyDis', 'StorePurchaseMoneyDis')->name('storePurchaseMoneyDis');
    });

    Route::controller(InstallmentController::class)->group(function () {
        Route::get('/instalment/{purchaseId}/{installmentId?}', 'Instalment')->name('instalment');
        Route::get('/addInstalment/{purchaseId}', 'AddInstalment')->name('addInstalment');
        Route::get('/addInstallmentMount/{installmentDetailId}', 'AddInstallmentMount')->name('addInstallmentMount');
        Route::post('/addInstallmentMount', 'StoreInstallmentMount')->name('storeInstallmentMount');

        Route::post('/instalment/addInstalment', 'StoreInstalment')->name('instalment.storeInstalment');
    });

    Route::controller(ChequeController::class)->group(function () {
        Route::get('/cheque/{purchaseId}', 'Cheque')->name('cheque');
        Route::get('/cheque/addCheque/{purchaseId}', 'AddCheque')->name('cheque.addCheque');
        Route::post('/cheque/addCheque', 'StoreCheque')->name('cheque.storeCheque');

        Route::get('addChequeMount/{chequeId}', 'AddChequeMount')->name('addChequeMount');
        Route::post('addChequeMount', 'StoreChequeMount')->name('storeChequeMount');
        Route::get('chequeImg/{chequeId}', 'ChequeImg')->name('chequeImg');
    });
});

Route::prefix('/sales')->name('sales.')->middleware('auth:admin')->group(function () {
    Route::controller(SaleController::class)->group(function () {
        Route::get('/addsale', 'AddSale')->name('addsale');
        Route::get('/updateSale/{saleId}', 'UpdateSale')->name('updateSale');
        Route::put('/updateSale', 'EditeSale')->name('editeSale');
        Route::post('/addsale', 'StoreSale')->name('storeSale');

        Route::controller(SaleDetailController::class)->group(function () {
            Route::get('/saleDetails/{saleId}', 'SaleDetails')->name('saleDetails');
            Route::get('/saleDetails/addSaleDetails/{saleId}', 'AddSaleDetails')->name('saleDetails.addSaleDetails');
            Route::post('/saleDetails', 'StoreSaleDetails')->name('saleDetails.storeSaleDetails');
            Route::get('/updateSaleDetail/{saleDetailId}', 'UpdateSaleDetail')->name('updateSaleDetail');
            Route::get('/cancelSaleDetail/{saleDetailId}', 'CancelSaleDetail')->name('cancelSaleDetail');
        });
        Route::controller(TransactionSaleController::class)->group(function () {
            Route::get('/addSaleMoney/{saleId}', 'AddSaleMoney')->name('addSaleMoney');
            Route::post('/addSaleMoney', 'StoreSaleMoney')->name('storeSaleMoney');

            Route::get('/addSaleMoneyDis/{saleDetail}', 'AddSaleMoneyDis')->name('addSaleMoneyDis');
            Route::post('/addSaleMoneyDis', 'StoreSaleMoneyDis')->name('storeSaleMoneyDis');

            Route::get('/transactionsSale/{saleId}', 'TransactionsSale')->name('transactionsSale');
            Route::get('/transactionsSale/addTransactionsSale/{saleId}', 'AddTransactionsSale')->name('transactionsSale.addTransactionsSale');
            Route::post('/transactionsSale/addTransactionsSale', 'StoreTransactionsSale')->name('transactionsSale.storeTransactionsSale');
        });

        Route::controller(InstallmentSaleController::class)->group(function () {
            Route::get('/instalment/{saleId}/{installmentId?}', 'Instalment')->name('instalment');
            Route::get('/addInstalment/{saleId}', 'AddInstalment')->name('addInstalment');
            Route::post('/instalment/addInstalment', 'StoreInstalment')->name('instalment.storeInstalment');

            Route::get('/addInstallmentMount/{installmentDetailId}', 'AddInstallmentMount')->name('addInstallmentMount');
            Route::post('/addInstallmentMount', 'StoreInstallmentMount')->name('storeInstallmentMount');
        });

        Route::controller(PdfController::class)->group(function () {
            Route::get('/custemerSale/{saleId}', 'CustemerSale')->name('custemerSale');
        });

        Route::controller(ChequeSaleController::class)->group(function () {
            Route::get('/cheque/{saleId}', 'Cheque')->name('cheque');
            Route::get('/cheque/addCheque/{saleId}', 'AddCheque')->name('cheque.addCheque');
            Route::post('/cheque/addCheque', 'StoreCheque')->name('cheque.storeCheque');
            Route::get('chequeImg/{chequeId}', 'ChequeImg')->name('chequeImg');
            Route::get('addChequeMount/{chequeId}', 'AddChequeMount')->name('addChequeMount');
            Route::post('addChequeMount', 'StoreChequeMount')->name('storeChequeMount');
        });
    });
});

Route::controller(StockController::class)->prefix('/stocks')->name('stocks.')->middleware('auth:admin')->group(function () {
    Route::get('/StockMovments/{productDetailId?}', 'StockMovments')->name('StockMovments');
    Route::get('/stockRefrence/{purchaseDetailId}', 'StockRefrence')->name('stockRefrence');
});

Route::controller(UserController::class)->prefix('/users')->name('users.')->middleware('auth:admin')->group(function () {
    Route::get('/attendances/{userId}', 'Attendances')->name('attendances');
    Route::get('/advance/{userId}', 'Advance')->name('advance');
    Route::get('/salary/{userId}', 'Salary')->name('salary');
    Route::get('/updateUser/{userId}', 'UpdateUser')->name('updateUser');
    Route::put('/updateUser', 'EditUser')->name('editUser');
});

Route::controller(FinancialController::class)->prefix('/financials')->name('financials.')->middleware('auth:admin')->group(function () {
    Route::get('/assets', 'Assets')->name('assets');
    Route::get('/liabilities', 'Liabilities')->name('liabilities');
    Route::get('/revenues', 'Revenues')->name('revenues');
    Route::get('/receivable', 'Receivable')->name('receivable');
    Route::get('/expenses', 'Expenses')->name('expenses');
});

Route::controller(DashboardController::class)->middleware('auth:admin')->group(function () {
    Route::get('/purchaseDashboard', 'PurchaseDashboard')->name('purchaseDashboard');
    Route::get('/saleDashboard', 'SaleDashboard')->name('saleDashboard');
    Route::get('/stockDashboard', 'StockDashboard')->name('stockDashboard');
});

Route::controller(ReportsController::class)->middleware('auth:admin')->group(function () {
    Route::get('/accountStatementCustemer', 'AccountStatementCustemer')->name('accountStatementCustemer');
    Route::get('/productName', 'ProductName')->name('productName');
    Route::get('/reportsCustemers', 'ReportCustemers')->name('reportsCustemers');
});

Route::controller(MaterialController::class)->prefix('/rawMaterials')->name('rawMaterials.')->middleware('auth:admin')->group(function () {
    Route::get('/addMatrial', 'AddMatrial')->name('addMatrial');
    Route::post('/addMatrial', 'StoreMatrial')->name('storeMatrial');
});
