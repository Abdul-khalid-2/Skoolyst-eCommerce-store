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
}
