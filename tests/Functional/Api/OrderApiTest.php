<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Request\CaptureRequest;
use Etrias\AfterPayConnector\Request\RefundOrderRequest;
use Etrias\AfterPayConnector\Request\VoidAuthorizationRequest;
use Etrias\AfterPayConnector\Type\Cancellation;
use Etrias\AfterPayConnector\Type\CancellationItem;
use Etrias\AfterPayConnector\Type\Capture;
use Etrias\AfterPayConnector\Type\CaptureItem;
use Etrias\AfterPayConnector\Type\OrderItemExtended;
use Etrias\AfterPayConnector\Type\Payment;
use Etrias\AfterPayConnector\Type\Refund;
use Etrias\AfterPayConnector\Type\RefundItem;

/**
 * @internal
 */
final class OrderApiTest extends ApiTestCase
{
    public function testCapturePayment(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $request = new CaptureRequest();
        $request->orderDetails = TestData::orderSummary();

        $response = $this->orderApi->capturePayment($orderNumber, $request);

        self::assertSame('38', $response->authorizedAmount);
        self::assertSame('38', $response->capturedAmount);
        self::assertNotEmpty($response->captureNumber);
        self::assertSame('0', $response->remainingAuthorizedAmount);
    }

    public function testVoidAuthorization(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $request = new VoidAuthorizationRequest();
        $request->cancellationDetails = TestData::orderSummary();

        $response = $this->orderApi->voidAuthorization($orderNumber, $request);

        self::assertSame('0', $response->remainingAuthorizedAmount);
        self::assertSame('38', $response->totalAuthorizedAmount);
        self::assertSame('0', $response->totalCapturedAmount);
    }

    public function testRefundPayment(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $captureNumber = $this->capture($orderNumber);

        $request = RefundOrderRequest::forRefund($captureNumber)
            ->withItems(TestData::refundOrderItem())
        ;

        $response = $this->orderApi->refundPayment($orderNumber, $request);

        self::assertIsString($response->refundNumbers[0]);
        self::assertSame('38', $response->totalAuthorizedAmount);
        self::assertSame('38', $response->totalCapturedAmount);
        self::assertSame('12.5', $response->totalRefundedAmount);
    }

    public function testGetOrder(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $response = $this->orderApi->getOrder($orderNumber);

        self::assertSame([], $response->cancellations);
        self::assertSame([], $response->captures);
        self::assertSame('EUR', $response->orderDetails->currency);
        self::assertInstanceOf(\DateTimeImmutable::class, $response->orderDetails->expirationDate);
        self::assertInstanceOf(\DateTimeImmutable::class, $response->orderDetails->insertedAt);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->orderDetails->orderId);
        self::assertInstanceOf(OrderItemExtended::class, $response->orderDetails->orderItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->orderDetails->orderItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->orderDetails->orderItems[0]->quantity);
        self::assertSame($orderNumber, $response->orderDetails->orderNumber);
        self::assertSame('38', $response->orderDetails->totalGrossAmount);
        self::assertSame('26.5', $response->orderDetails->totalNetAmount);
        self::assertInstanceOf(\DateTimeImmutable::class, $response->orderDetails->updatedAt);
        self::assertInstanceOf(Payment::class, $response->payment);
        self::assertSame([], $response->refunds);
    }

    public function testGetOrderCanceled(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $this->cancel($orderNumber);

        $response = $this->orderApi->getOrder($orderNumber);

        self::assertInstanceOf(Cancellation::class, $response->cancellations[0]);
        self::assertSame('38', $response->cancellations[0]->cancellationAmount);
        self::assertInstanceOf(CancellationItem::class, $response->cancellations[0]->cancellationItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->cancellations[0]->cancellationItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->cancellations[0]->cancellationItems[0]->quantity);
        self::assertSame($response->cancellations[0]->cancellationNo, $response->cancellations[0]->cancellationItems[0]->cancellationNumber);
        self::assertIsString($response->cancellations[0]->cancellationNo);
        self::assertSame([], $response->captures);
        self::assertSame([], $response->refunds);
    }

    public function testGetOrderCaptured(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $this->capture($orderNumber);

        $response = $this->orderApi->getOrder($orderNumber);

        self::assertSame([], $response->cancellations);
        self::assertInstanceOf(Capture::class, $response->captures[0]);
        self::assertSame('38', $response->captures[0]->amount);
        self::assertSame('38', $response->captures[0]->balance);
        self::assertInstanceOf(CaptureItem::class, $response->captures[0]->captureItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->captures[0]->captureItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->captures[0]->captureItems[0]->quantity);
        self::assertIsString($response->captures[0]->captureNumber);
        self::assertSame('EUR', $response->captures[0]->currency);
        self::assertSame('', $response->captures[0]->customerNumber);
        self::assertNull($response->captures[0]->dueDate);
        self::assertInstanceOf(\DateTimeImmutable::class, $response->captures[0]->insertedAt);
        self::assertNull($response->captures[0]->invoiceDate);
        self::assertInstanceOf(\DateTimeImmutable::class, $response->captures[0]->orderDate);
        self::assertSame($orderNumber, $response->captures[0]->orderNumber);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->captures[0]->reservationId);
        self::assertSame('0', $response->captures[0]->totalRefundedAmount);
        self::assertNull($response->captures[0]->updatedAt);
        self::assertSame([], $response->refunds);
    }

    public function testGetOrderRefunded(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $captureNumber = $this->capture($orderNumber);
        $refundNumbers = $this->refund($orderNumber, $captureNumber);

        $response = $this->orderApi->getOrder($orderNumber);

        self::assertSame([], $response->cancellations);
        self::assertInstanceOf(Refund::class, $response->refunds[0]);
        self::assertSame('-12.5', $response->refunds[0]->amount);
        self::assertSame('-12.5', $response->refunds[0]->balance);
        self::assertSame($captureNumber, $response->refunds[0]->captureNumber);
        self::assertSame('EUR', $response->refunds[0]->currency);
        self::assertSame('', $response->refunds[0]->customerNumber);
        self::assertInstanceOf(\DateTimeImmutable::class, $response->refunds[0]->insertedAt);
        self::assertSame($orderNumber, $response->refunds[0]->orderNumber);
        self::assertInstanceOf(RefundItem::class, $response->refunds[0]->refundItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->refunds[0]->refundItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->refunds[0]->refundItems[0]->quantity);
        self::assertSame($refundNumbers[0], $response->refunds[0]->refundNumber);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->refunds[0]->reservationId);
        self::assertNull($response->refunds[0]->updatedAt);
    }
}
