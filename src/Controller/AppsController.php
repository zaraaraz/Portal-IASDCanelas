<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/apps', name: 'apps_')]
final class AppsController extends AbstractController
{
    #[Route('/calendar', name: 'calendar')]
    public function calendar(): Response
    {
        return $this->render('apps/calendar.html.twig');
    }

    #[Route('/chat', name: 'chat')]
    public function chat(): Response
    {
        return $this->render('apps/chat-app.html.twig');
    }

    #[Route('/kanban', name: 'kanban')]
    public function kanban(): Response
    {
        return $this->render('apps/kanban.html.twig');
    }

    // Email routes
    #[Route('/email/inbox', name: 'email_inbox')]
    public function emailInbox(): Response
    {
        return $this->render('apps/email/mail.html.twig');
    }

    #[Route('/email/details', name: 'email_details')]
    public function emailDetails(): Response
    {
        return $this->render('apps/email/mail-details.html.twig');
    }

    #[Route('/email/compose', name: 'email_compose')]
    public function emailCompose(): Response
    {
        return $this->render('apps/email/compose.html.twig');
    }

    // E-commerce routes
    #[Route('/ecommerce/products', name: 'ecommerce_products')]
    public function ecommerceProducts(): Response
    {
        return $this->render('apps/e-commerce/ecommerce-products.html.twig');
    }

    #[Route('/ecommerce/product-details', name: 'ecommerce_product_details')]
    public function ecommerceProductDetails(): Response
    {
        return $this->render('apps/e-commerce/ecommerce-products-details.html.twig');
    }

    #[Route('/ecommerce/product-edit', name: 'ecommerce_product_edit')]
    public function ecommerceProductEdit(): Response
    {
        return $this->render('apps/e-commerce/ecommerce-product-edit.html.twig');
    }

    #[Route('/ecommerce/cart', name: 'ecommerce_cart')]
    public function ecommerceCart(): Response
    {
        return $this->render('apps/e-commerce/ecommerce-cart.html.twig');
    }

    #[Route('/ecommerce/checkout', name: 'ecommerce_checkout')]
    public function ecommerceCheckout(): Response
    {
        return $this->render('apps/e-commerce/ecommerce-checkout.html.twig');
    }

    #[Route('/ecommerce/customer', name: 'ecommerce_customer')]
    public function ecommerceCustomer(): Response
    {
        return $this->render('apps/e-commerce/ecommerce-customer.html.twig');
    }

    #[Route('/ecommerce/seller', name: 'ecommerce_seller')]
    public function ecommerceSeller(): Response
    {
        return $this->render('apps/e-commerce/ecommerce-seller.html.twig');
    }

    // Order routes
    #[Route('/order/list', name: 'order_list')]
    public function orderList(): Response
    {
        return $this->render('apps/order/order-list.html.twig');
    }

    #[Route('/order/details', name: 'order_details')]
    public function orderDetails(): Response
    {
        return $this->render('apps/order/order-details.html.twig');
    }

    // Project routes
    #[Route('/project/grid', name: 'project_grid')]
    public function projectGrid(): Response
    {
        return $this->render('apps/project/project-grid.html.twig');
    }

    #[Route('/project/list', name: 'project_list')]
    public function projectList(): Response
    {
        return $this->render('apps/project/project-list.html.twig');
    }

    #[Route('/project/overview', name: 'project_overview')]
    public function projectOverview(): Response
    {
        return $this->render('apps/project/project-overview.html.twig');
    }

    #[Route('/project/task', name: 'project_task')]
    public function projectTask(): Response
    {
        return $this->render('apps/project/project-task.html.twig');
    }

    #[Route('/project/budget', name: 'project_budget')]
    public function projectBudget(): Response
    {
        return $this->render('apps/project/project-budget.html.twig');
    }

    #[Route('/project/files', name: 'project_files')]
    public function projectFiles(): Response
    {
        return $this->render('apps/project/project-files.html.twig');
    }

    #[Route('/project/team', name: 'project_team')]
    public function projectTeam(): Response
    {
        return $this->render('apps/project/project-team.html.twig');
    }

    #[Route('/project/add', name: 'project_add')]
    public function projectAdd(): Response
    {
        return $this->render('apps/project/add-project.html.twig');
    }

    // CRM routes
    #[Route('/crm/contacts', name: 'crm_contacts')]
    public function crmContacts(): Response
    {
        return $this->render('apps/crm/crm-contacts.html.twig');
    }

    #[Route('/crm/company', name: 'crm_company')]
    public function crmCompany(): Response
    {
        return $this->render('apps/crm/crm-company.html.twig');
    }

    #[Route('/crm/deals', name: 'crm_deals')]
    public function crmDeals(): Response
    {
        return $this->render('apps/crm/deals.html.twig');
    }

    #[Route('/crm/deals-single', name: 'crm_deals_single')]
    public function crmDealsSingle(): Response
    {
        return $this->render('apps/crm/deals-single.html.twig');
    }

    // Invoice routes
    #[Route('/invoice/list', name: 'invoice_list')]
    public function invoiceList(): Response
    {
        return $this->render('apps/invoice/invoice-list.html.twig');
    }

    #[Route('/invoice/detail', name: 'invoice_detail')]
    public function invoiceDetail(): Response
    {
        return $this->render('apps/invoice/invoice-detail.html.twig');
    }

    // Profile routes
    #[Route('/profile/overview', name: 'profile_overview')]
    public function profileOverview(): Response
    {
        return $this->render('apps/profile/profile-overview.html.twig');
    }

    #[Route('/profile/project', name: 'profile_project')]
    public function profileProject(): Response
    {
        return $this->render('apps/profile/profile-project.html.twig');
    }

    #[Route('/profile/team', name: 'profile_team')]
    public function profileTeam(): Response
    {
        return $this->render('apps/profile/profile-team.html.twig');
    }

    #[Route('/profile/followers', name: 'profile_followers')]
    public function profileFollowers(): Response
    {
        return $this->render('apps/profile/profile-followers.html.twig');
    }

    #[Route('/profile/activity', name: 'profile_activity')]
    public function profileActivity(): Response
    {
        return $this->render('apps/profile/profile-activity.html.twig');
    }

    #[Route('/profile/settings', name: 'profile_settings')]
    public function profileSettings(): Response
    {
        return $this->render('apps/profile/profile-settings.html.twig');
    }

    // Blog routes
    #[Route('/blog/list', name: 'blog_list')]
    public function blogList(): Response
    {
        return $this->render('apps/blog/blog-list.html.twig');
    }

    #[Route('/blog/detail', name: 'blog_detail')]
    public function blogDetail(): Response
    {
        return $this->render('apps/blog/blog-post-detail.html.twig');
    }

    #[Route('/blog/create', name: 'blog_create')]
    public function blogCreate(): Response
    {
        return $this->render('apps/blog/create-blog-post.html.twig');
    }
}
