<?php

namespace App\Providers;

use App\Contracts\Repositories\AccountTypeRepositoryInterface;
use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Contracts\Repositories\BankAccountRepositoryInterface;
use App\Contracts\Repositories\CategoryRipositoryInterface;
use App\Contracts\Repositories\ChequeBookRepositoryInterface;
use App\Contracts\Repositories\ChequeNumberRepositoryInterface;
use App\Contracts\Repositories\CustomerRepositoryInterface;
use App\Contracts\Repositories\LegalFormRepositoryInterface;
use App\Contracts\Repositories\LogoRepositoryInterface;
use App\Contracts\Repositories\OptionRepositoryInterface;
use App\Contracts\Repositories\ProductAttributeInterface;
use App\Contracts\Repositories\ProductRatingRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\ProductRipositoryInterface;
use App\Contracts\Repositories\QuestionAnswerRepositoryInterface;
use App\Contracts\Repositories\SliderRepositoryInterface;
use App\Contracts\Repositories\SocialMediaRepositoryInterface;
use App\Contracts\Repositories\TransactionInterface;
use App\Contracts\Repositories\UnitRepositoryInterface;
use App\Contracts\Repositories\PropertyRepositoryInterface;
use App\Contracts\Repositories\VendorWiseItemDetailsRepositoryInterface;
use App\Repositories\Elequent\AccountTypeRepository;
use App\Repositories\Elequent\BankAccountRepository;
use App\Repositories\Elequent\CategoryRipository;
use App\Repositories\Elequent\ChequeBookRepository;
use App\Repositories\Elequent\ChequeNumberRepository;
use App\Repositories\Elequent\CustomerRepository;
use App\Repositories\Elequent\LegalFormRepository;
use App\Repositories\Elequent\LogoRepository;
use App\Repositories\Elequent\OptionRepository;
use App\Repositories\Elequent\ProductAttributeRepository;
use App\Repositories\Elequent\ProductRatingRepository;
use App\Repositories\Elequent\ProductRepository;
use App\Repositories\Elequent\QuestionAnswerRepository;
use App\Repositories\Elequent\SliderRepository;
use App\Repositories\Elequent\SocialMediaRepository;
use App\Repositories\Elequent\TransactionRepository;
use App\Repositories\Elequent\UnitRepository;
use App\Repositories\Elequent\PropertyRepository;
use App\Repositories\Elequent\VendorWiseItemDetailsRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\AdminRepositoryInterface;
use App\Contracts\Repositories\AuthorizationRepositoryInterface;
use App\Contracts\Repositories\BankRepositoryInterface;
use App\Contracts\Repositories\BaseRepositoryInterface;
use App\Contracts\Repositories\BrandRepositoryInterface;
use App\Contracts\Repositories\ServiceWarrantyRepositoryInterface;
use App\Contracts\Repositories\BusinessInfoRepositoryInterface;
use App\Contracts\Repositories\CouponRepositoryInterface;
use App\Contracts\Repositories\DeliveryRepositoryInterface;
use App\Contracts\Repositories\FlashSaleRepositoryInterface;
use App\Contracts\Repositories\InvoiceSettingsRepositoryInterface;
use App\Contracts\Repositories\MediaRepositoryInterface;
use App\Contracts\Repositories\OrderDetailsRepositoryInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Repositories\ShippingRepositoryInterface;
use App\Contracts\Repositories\TemplateRepositoryInterface;
use App\Contracts\Repositories\VariantRepositoryInterface;
use App\Contracts\Repositories\VendorRepositoryInterface;
use App\Contracts\Repositories\VoucherRepositoryInterface;
use App\Contracts\Repositories\WishListRepositoryInterface;
use App\Repositories\Elequent\AddressRepository;
use App\Repositories\Elequent\AdminRepository;
use App\Repositories\Elequent\AuthorizationRepository;
use App\Repositories\Elequent\BankRepository;
use App\Repositories\Elequent\BaseRepository;
use App\Repositories\Elequent\BrandRepository;
use App\Repositories\Elequent\ServiceWarrantyRepository;
use App\Repositories\Elequent\BusinessInfoRepository;
use App\Repositories\Elequent\CouponRepository;
use App\Repositories\Elequent\DeliveryRepository;
use App\Repositories\Elequent\FlashSaleRepository;
use App\Repositories\Elequent\InvoiceSettingsRepository;
use App\Repositories\Elequent\MediaRepository;
use App\Repositories\Elequent\OrderDetailsRepository;
use App\Repositories\Elequent\OrderRepository;
use App\Repositories\Elequent\ShippingRepository;
use App\Repositories\Elequent\TemplateRepository;
use App\Repositories\Elequent\VariantRepository;
use App\Repositories\Elequent\VendorRepository;
use App\Repositories\Elequent\VoucherRepository;
use App\Repositories\Elequent\WishListRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthorizationRepositoryInterface::class, AuthorizationRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(ServiceWarrantyRepositoryInterface::class, ServiceWarrantyRepository::class);
        $this->app->bind(TemplateRepositoryInterface::class, TemplateRepository::class);
        $this->app->bind(VendorRepositoryInterface::class, VendorRepository::class);
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
        $this->app->bind(CategoryRipositoryInterface::class, CategoryRipository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(FlashSaleRepositoryInterface::class, FlashSaleRepository::class);
        $this->app->bind(WishListRepositoryInterface::class, WishListRepository::class);
        $this->app->bind(ProductRatingRepositoryInterface::class, ProductRatingRepository::class);
        $this->app->bind(QuestionAnswerRepositoryInterface::class, QuestionAnswerRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(ChequeBookRepositoryInterface::class, ChequeBookRepository::class);
        $this->app->bind(BankAccountRepositoryInterface::class, BankAccountRepository::class);
        $this->app->bind(OrderDetailsRepositoryInterface::class, OrderDetailsRepository::class);
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        $this->app->bind(VoucherRepositoryInterface::class, VoucherRepository::class);
        $this->app->bind(ChequeNumberRepositoryInterface::class, ChequeNumberRepository::class);
        $this->app->bind(ShippingRepositoryInterface::class,ShippingRepository::class);
        $this->app->bind(VendorWiseItemDetailsRepositoryInterface::class,VendorWiseItemDetailsRepository::class);
        $this->app->bind(VariantRepositoryInterface::class,VariantRepository::class);
        $this->app->bind(LegalFormRepositoryInterface::class,LegalFormRepository::class);
        $this->app->bind(MediaRepositoryInterface::class,MediaRepository::class);
        $this->app->bind(AddressRepositoryInterface::class,AddressRepository::class);
        $this->app->bind(BusinessInfoRepositoryInterface::class,BusinessInfoRepository::class);
        $this->app->bind(InvoiceSettingsRepositoryInterface::class,InvoiceSettingsRepository::class);
        $this->app->bind(DeliveryRepositoryInterface::class,DeliveryRepository::class);
        $this->app->bind(ShippingRepositoryInterface::class, ShippingRepository::class);
        $this->app->bind(VendorWiseItemDetailsRepositoryInterface::class, VendorWiseItemDetailsRepository::class);
        $this->app->bind(VariantRepositoryInterface::class, VariantRepository::class);
        $this->app->bind(LegalFormRepositoryInterface::class, LegalFormRepository::class);
        $this->app->bind(MediaRepositoryInterface::class, MediaRepository::class);
        $this->app->bind(BankRepositoryInterface::class, BankRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(BusinessInfoRepositoryInterface::class, BusinessInfoRepository::class);
        $this->app->bind(InvoiceSettingsRepositoryInterface::class, InvoiceSettingsRepository::class);
        $this->app->bind(ProductAttributeInterface::class, ProductAttributeRepository::class);
        $this->app->bind(SliderRepositoryInterface::class, SliderRepository::class);
        $this->app->bind(SocialMediaRepositoryInterface::class, SocialMediaRepository::class);
        $this->app->bind(LogoRepositoryInterface::class, LogoRepository::class);



        // account part start from here 

        $this->app->bind(AccountTypeRepositoryInterface::class, AccountTypeRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
