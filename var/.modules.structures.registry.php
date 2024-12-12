# <?php if (!defined('LC_DS')) { die(); } ?>

CDev\AuthorizeNet:
  tables: {  }
  columns: {  }
CDev\Bestsellers:
  tables: {  }
  columns: {  }
CDev\ContactUs:
  tables: {  }
  columns: {  }
CDev\FeaturedProducts:
  tables: [featured_products]
  columns: {  }
CDev\GoogleAnalytics:
  tables: {  }
  columns: {  }
CDev\GoSocial:
  tables: {  }
  columns: { pages: { ogMeta: 'ogMeta LONGTEXT NOT NULL', showSocialButtons: 'showSocialButtons TINYINT(1) UNSIGNED NOT NULL' }, products: { ogMeta: 'ogMeta LONGTEXT NOT NULL', useCustomOG: 'useCustomOG TINYINT(1) UNSIGNED NOT NULL' } }
CDev\MarketPrice:
  tables: {  }
  columns: { products: { marketPrice: 'marketPrice NUMERIC(14, 4) NOT NULL' } }
CDev\Moneybookers:
  tables: {  }
  columns: {  }
CDev\Paypal:
  tables: {  }
  columns: {  }
CDev\SalesTax:
  tables: [sales_tax_rates, sales_taxes, sales_tax_translations]
  columns: {  }
CDev\SimpleCMS:
  tables: [page_images, menus, menu_translations, pages, page_translations]
  columns: {  }
CDev\TinyMCE:
  tables: {  }
  columns: {  }
CDev\TwoCheckout:
  tables: {  }
  columns: {  }
CDev\VAT:
  tables: [vat_tax_rates, vat_taxes, vat_tax_translations]
  columns: {  }
CDev\XMLSitemap:
  tables: {  }
  columns: {  }
XC\Add2CartPopup:
  tables: [add2cart_popup_sources]
  columns: {  }
XC\ColorSchemes:
  tables: {  }
  columns: {  }
XC\Mobile:
  tables: {  }
  columns: {  }
XC\SagePay:
  tables: {  }
  columns: {  }
XC\Stripe:
  tables: {  }
  columns: {  }
XC\ThemeTweaker:
  tables: {  }
  columns: {  }
Tony\News:
  tables: [news]
  columns: {  }
