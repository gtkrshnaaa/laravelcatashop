<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => "# About LaravelCataShop\n\n## Our Story\n\nLaravelCataShop was founded with a simple mission: to provide quality products at affordable prices with exceptional customer service.\n\n## Our Values\n\n- **Quality First**: We carefully select every product in our catalog\n- **Customer Satisfaction**: Your happiness is our priority\n- **Trust & Transparency**: Honest pricing, no hidden fees\n- **Fast Delivery**: We work with reliable couriers\n\n## Why Choose Us?\n\n1. Wide selection of quality products\n2. Competitive prices\n3. Secure payment options\n4. Responsive customer support\n5. Easy returns and exchanges\n\nThank you for choosing LaravelCataShop!",
                'is_active' => true,
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'content' => "# Terms and Conditions\n\nLast updated: " . now()->format('F d, Y') . "\n\n## 1. Acceptance of Terms\n\nBy accessing and using LaravelCataShop, you accept and agree to be bound by these terms.\n\n## 2. Products and Pricing\n\n- All prices are in Indonesian Rupiah (Rp)\n- Prices may change without prior notice\n- Product availability is subject to stock\n\n## 3. Orders and Payment\n\n- Orders are confirmed upon successful payment\n- We accept Bank Transfer and Cash on Delivery\n- Payment must match the exact total amount including unique code\n\n## 4. Shipping and Delivery\n\n- Delivery times vary by location\n- Customers are responsible for providing accurate addresses\n- We are not liable for delays caused by couriers\n\n## 5. Returns and Refunds\n\n- Returns accepted within 7 days of receipt\n- Product must be in original condition\n- Refunds processed within 14 business days\n\n## 6. Customer Responsibility\n\n- Provide accurate information\n- Maintain account security\n- Use the platform lawfully\n\nFor questions, contact us via WhatsApp.",
                'is_active' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => "# Privacy Policy\n\nEffective date: " . now()->format('F d, Y') . "\n\n## Information We Collect\n\n### Personal Information\n- Name and contact details\n- Email address\n- WhatsApp number\n- Delivery address\n\n### Order Information\n- Purchase history\n- Payment method\n- Shipping preferences\n\n## How We Use Your Information\n\nWe use your information to:\n- Process and fulfill orders\n- Communicate order status\n- Improve our services\n- Send promotional offers (with consent)\n\n## Data Security\n\nWe implement appropriate security measures to protect your personal information.\n\n## Your Rights\n\nYou have the right to:\n- Access your personal data\n- Correct inaccurate data\n- Request deletion of data\n- Opt-out of marketing communications\n\n## Cookies\n\nWe use essential cookies for functionality. No tracking cookies are used.\n\n## Contact Us\n\nFor privacy concerns, email us at privacy@laravelcatashop.test",
                'is_active' => true,
            ],
            [
                'title' => 'Shipping Information',
                'slug' => 'shipping-information',
                'content' => "# Shipping Information\n\n## Delivery Areas\n\nWe currently ship to all major cities in Indonesia.\n\n## Shipping Methods\n\n### Standard Shipping\n- 3-5 business days\n- Available nationwide\n- Tracking number provided\n\n### Express Shipping\n- 1-2 business days\n- Major cities only\n- Higher shipping fee applies\n\n### Same-Day Delivery\n- Selected areas only\n- Order before 12 PM\n- Subject to availability\n\n## Shipping Costs\n\nShipping costs are calculated based on:\n- Destination\n- Package weight\n- Delivery speed\n\n**Free shipping** on orders above Rp 150,000!\n\n## Order Processing\n\n- Orders processed within 24 hours\n- You'll receive tracking info via WhatsApp\n- Contact us for urgent deliveries\n\n## Package Tracking\n\nTrack your order:\n1. Login to your account\n2. Go to Order History\n3. Click on your order\n4. View tracking number",
                'is_active' => true,
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'content' => "# Frequently Asked Questions\n\n## General Questions\n\n### How do I place an order?\nBrowse our catalog, add items to cart, and proceed to checkout. Fill in your details and choose payment method.\n\n### What payment methods do you accept?\nWe accept Bank Transfer and Cash on Delivery (COD).\n\n### Can I modify my order?\nContact us immediately via WhatsApp. We'll try our best to accommodate changes if order hasn't shipped.\n\n## Payment Questions\n\n### What is the unique code?\nA 3-digit number added to your total for payment verification. This helps us identify your payment quickly.\n\n### How long until my payment is verified?\nTypically within 1-4 hours during business hours. Send payment proof via WhatsApp for faster verification.\n\n### Is my payment information secure?\nWe don't store payment card information. Bank transfers are directly to our account.\n\n## Shipping Questions\n\n### How long is delivery?\nStandard shipping: 3-5 business days. Express: 1-2 days.\n\n### Can I track my order?\nYes! Login to your account to view tracking information.\n\n### What if I'm not home?\nCourier will contact you. Alternatively, provide an alternative receive location.\n\n## Returns & Refunds\n\n### What's your return policy?\n7 days from receipt. Product must be unused and in original packaging.\n\n### How do I request a return?\nContact us via WhatsApp with your order number and reason for return.\n\n### When will I get my refund?\nRefunds processed within 14 business days of approved return.\n\n## Still have questions?\nContact our customer service via WhatsApp!",
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
