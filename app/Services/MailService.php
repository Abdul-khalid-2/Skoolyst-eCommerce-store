<?php
declare(strict_types=1);

namespace Skoolyst\Services;

/**
 * Thin client for the shared Skoolyst Email API (ads.skoolyst.com/api/v1).
 * Every Skoolyst app sends mail through this one HTTP endpoint rather than
 * talking SMTP directly — see config/mail.php for the api_key/source_app.
 */
class MailService {
    private string $baseUrl;
    private string $apiKey;
    private string $sourceApp;

    public function __construct() {
        $this->baseUrl = rtrim((string) config('mail.api.base_url'), '/');
        $this->apiKey = (string) config('mail.api.api_key');
        $this->sourceApp = (string) config('mail.api.source_app');
    }

    /**
     * Sends one plain-text email via the Skoolyst Email API. Never throws —
     * a mail outage must not break checkout or any other caller, so failures
     * are logged and false is returned instead.
     */
    public function send(string $to, string $subject, string $body): bool {
        if ($this->apiKey === '') {
            error_log('MailService: SKOOLYST_MAIL_API_KEY is not configured, skipping send to ' . $to);
            return false;
        }

        $ch = curl_init($this->baseUrl . '/email/send');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode([
                'api_key' => $this->apiKey,
                'source_app' => $this->sourceApp,
                'to' => $to,
                'subject' => $subject,
                'body' => $body,
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);
        $raw = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($status === 201) {
            return true;
        }

        // 503 (all_accounts_exhausted / send_failed) is the one case worth a
        // retry later; everything else means the request itself is wrong.
        // Neither is actionable synchronously here, so just log for now.
        error_log(sprintf('MailService: send to %s failed (HTTP %d): %s', $to, $status, $curlError !== '' ? $curlError : (string) $raw));
        return false;
    }

    /** Order confirmation email, sent right after a checkout succeeds. */
    public function sendOrderConfirmation(array $order, array $items): bool {
        $lines = [
            'Hi ' . $order['full_name'] . ',',
            '',
            'Thanks for your order! Here are your order details:',
            '',
            'Order Number: ' . $order['order_number'],
            '',
        ];

        foreach ($items as $item) {
            $lines[] = sprintf('- %s x%d — Rs. %s', $item['product_name'], (int) $item['qty'], number_format((float) $item['line_total'], 2));
        }

        $lines = array_merge($lines, [
            '',
            'Subtotal: Rs. ' . number_format((float) $order['subtotal'], 2),
            'Delivery Fee: Rs. ' . number_format((float) $order['delivery_fee'], 2),
            'Total: Rs. ' . number_format((float) $order['total'], 2),
            '',
            'Delivery Address:',
            $order['address'] . ', ' . $order['city'],
            '',
            'Payment Method: ' . ($order['payment_method'] === 'cod' ? 'Cash on Delivery' : $order['payment_method']),
            '',
            'We will notify you once your order status changes.',
            '',
            '— Skoolyst Store',
        ]);

        return $this->send($order['email'], 'Order Confirmation — ' . $order['order_number'], implode("\n", $lines));
    }

    /** Welcome email sent right after a new account is registered. */
    public function sendWelcomeEmail(string $name, string $email): bool {
        $body = implode("\n", [
            'Hi ' . $name . ',',
            '',
            'Welcome to Skoolyst Store! Your account has been created successfully.',
            '',
            'You can now browse stores, add products to your cart, and check out.',
            '',
            '— Skoolyst Store',
        ]);

        return $this->send($email, 'Welcome to Skoolyst Store', $body);
    }

    /** Sent to the owner right after they submit a new store via "Open a Store". */
    public function sendStoreSubmittedEmail(string $ownerEmail, string $ownerName, string $storeName): bool {
        $body = implode("\n", [
            'Hi ' . $ownerName . ',',
            '',
            'Your store "' . $storeName . '" has been submitted to Skoolyst Store.',
            '',
            'It is currently pending approval — we will let you know once it has been reviewed by our team.',
            '',
            '— Skoolyst Store',
        ]);

        return $this->send($ownerEmail, 'Store Submitted — ' . $storeName, $body);
    }

    /** Sent to the store owner right after they add a new product to their store. */
    public function sendProductAddedEmail(string $ownerEmail, string $ownerName, string $productName, string $storeName): bool {
        $body = implode("\n", [
            'Hi ' . $ownerName . ',',
            '',
            'Your product "' . $productName . '" has been added to your store "' . $storeName . '" on Skoolyst Store.',
            '',
            '— Skoolyst Store',
        ]);

        return $this->send($ownerEmail, 'Product Added — ' . $productName, $body);
    }

    /** Sent to the reviewer right after they submit a store review. */
    public function sendReviewSubmittedEmail(string $email, string $name, string $storeName, int $rating): bool {
        $body = implode("\n", [
            'Hi ' . $name . ',',
            '',
            'Thanks for reviewing "' . $storeName . '" (' . $rating . '/5) on Skoolyst Store!',
            '',
            'Your review is pending approval and will appear on the store page once approved by our team.',
            '',
            '— Skoolyst Store',
        ]);

        return $this->send($email, 'Review Submitted — ' . $storeName, $body);
    }
}
