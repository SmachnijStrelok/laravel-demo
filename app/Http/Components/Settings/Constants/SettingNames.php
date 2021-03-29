<?php
namespace App\Http\Components\Settings\Constants;

class SettingNames
{
    /**
     * Для базы данных
     */
    const IUL_PRICE = 'iul_price';
    const IUL_STORAGE_DAYS = 'iul_storage_days';
    const COUNT_START_MONEY = 'count_start_money';

    const PROSTOR_SMS_LOGIN = 'prostor_sms_login';
    const PROSTOR_SMS_PASSWORD = 'prostor_sms_password';
    const PROSTOR_SMS_SENDER = 'prostor_sms_sender';
    const PROSTOR_SMS_ENABLED = 'prostor_sms_enabled';

    const MAIL_HOST = 'mail_host';
    const MAIL_PORT = 'mail_port';
    const MAIL_USERNAME = 'mail_username';
    const MAIL_PASSWORD = 'mail_password';

    const INDEX_PAGE_BANNER_IMAGE_ID = 'index_page_banner_image_id';
    const INDEX_PAGE_TITLE = 'index_page_banner_title';
    const INDEX_PAGE_SUBTITLE = 'index_page_banner_subtitle';
    const INDEX_PAGE_TAG_TITLE = 'index_page_tag_title';
    const INDEX_PAGE_TAG_DESCRIPTION = 'index_page_tag_description';
    const INDEX_PAGE_TAG_KEYWORDS = 'index_page_tag_keywords';

    const COMPANY_SERVICES_PAGE_TAG_TITLE = 'company_services_page_tag_title';
    const COMPANY_SERVICES_PAGE_TAG_DESCRIPTION = 'company_services_page_tag_description';
    const COMPANY_SERVICES_PAGE_TAG_KEYWORDS = 'company_services_page_tag_keywords';

    const REVIEWS_PAGE_TAG_TITLE = 'reviews_page_tag_title';
    const REVIEWS_PAGE_TAG_DESCRIPTION = 'reviews_page_tag_description';
    const REVIEWS_PAGE_TAG_KEYWORDS = 'reviews_page_tag_keywords';

    const NEWS_PAGE_TAG_TITLE = 'news_page_tag_title';
    const NEWS_PAGE_TAG_DESCRIPTION = 'news_page_tag_description';
    const NEWS_PAGE_TAG_KEYWORDS = 'news_page_tag_keywords';

    const GALLERY_PAGE_TAG_TITLE = 'gallery_page_tag_title';
    const GALLERY_PAGE_TAG_DESCRIPTION = 'gallery_page_tag_description';
    const GALLERY_PAGE_TAG_KEYWORDS = 'gallery_page_tag_keywords';


    /**
     * .env файл
     */
    const APP_TYPE = 'APP_TYPE';
    const APP_URL = 'APP_URL';
    const APP_EMAIL_CONFIRMATION_URI = 'APP_EMAIL_CONFIRMATION_URI';
}