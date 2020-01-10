<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Exception\AfterPayException;
use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Etrias\AfterPayConnector\Request\AvailablePaymentMethodsRequest;
use Etrias\AfterPayConnector\Request\CaptureRequest;
use Etrias\AfterPayConnector\Request\RefundOrderRequest;
use Etrias\AfterPayConnector\Request\UpdateOrderRequest;
use Etrias\AfterPayConnector\Request\VoidAuthorizationRequest;
use Etrias\AfterPayConnector\Type\Cancellation;
use Etrias\AfterPayConnector\Type\CancellationItem;
use Etrias\AfterPayConnector\Type\Capture;
use Etrias\AfterPayConnector\Type\CaptureItem;
use Etrias\AfterPayConnector\Type\OrderItemExtended;
use Etrias\AfterPayConnector\Type\Outcome;
use Etrias\AfterPayConnector\Type\Payment;
use Etrias\AfterPayConnector\Type\Refund;
use Etrias\AfterPayConnector\Type\RefundItem;

/**
 * @internal
 */
final class OrdersTest extends ApiTestCase
{
    public function testAuthorizePayment(): void
    {
        $request = AuthorizePaymentRequest::forInvoice();
        $request->customer = TestData::checkoutCustomer();
        $request->order = TestData::order();

        $response = $this->orders->authorizePayment($request);

        self::assertSame(Outcome::ACCEPTED, $response->outcome);
        self::assertSame('John', $response->customer->firstName);
        self::assertSame('Doe 😁', $response->customer->lastName);
        self::assertSame('NL', $response->customer->addressList[0]->countryCode);
        self::assertNull($response->deliveryCustomer);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->checkoutId);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->reservationId);
    }

    public function testAvailablePaymentMethods(): void
    {
        $request = new AvailablePaymentMethodsRequest();
        $request->customer = TestData::checkoutCustomer();
        $request->order = TestData::order();

        $response = $this->orders->getAvailablePaymentMethods($request);

        self::assertSame(Outcome::ACCEPTED, $response->outcome);
        self::assertSame('John', $response->customer->firstName);
        self::assertSame('Doe 😁', $response->customer->lastName);
        self::assertSame('NL', $response->customer->addressList[0]->countryCode);
        self::assertNull($response->deliveryCustomer);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->checkoutId);
        self::assertIsString($response->paymentMethods[0]->title);
    }

    public function testCapturePayment(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $request = new CaptureRequest();
        $request->orderDetails = TestData::orderSummary();

        $response = $this->orders->capturePayment($orderNumber, $request);

        self::assertSame('38', $response->authorizedAmount);
        self::assertSame('38', $response->capturedAmount);
        self::assertIsString($response->captureNumber);
        self::assertSame('0', $response->remainingAuthorizedAmount);
    }

    public function testCapturePaymentWithUnknownOrder(): void
    {
        $request = new CaptureRequest();
        $request->orderDetails = TestData::orderSummary();

        $this->expectException(AfterPayException::class);

        $this->orders->capturePayment('UNKNOWN', $request);
    }

    public function testVoidAuthorization(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $request = new VoidAuthorizationRequest();
        $request->cancellationDetails = TestData::orderSummary();

        $response = $this->orders->voidAuthorization($orderNumber, $request);

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

        $response = $this->orders->refundPayment($orderNumber, $request);

        self::assertIsString($response->refundNumbers[0]);
        self::assertSame('38', $response->totalAuthorizedAmount);
        self::assertSame('38', $response->totalCapturedAmount);
        self::assertSame('12.5', $response->totalRefundedAmount);
    }

    public function testGetOrder(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $response = $this->orders->getOrder($orderNumber);

        self::assertSame([], $response->cancellations);
        self::assertSame([], $response->captures);
        self::assertSame('EUR', $response->orderDetails->currency);
        self::assertInstanceOf(\DateTime::class, $response->orderDetails->expirationDate);
        self::assertInstanceOf(\DateTime::class, $response->orderDetails->insertedAt);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->orderDetails->orderId);
        self::assertInstanceOf(OrderItemExtended::class, $response->orderDetails->orderItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->orderDetails->orderItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->orderDetails->orderItems[0]->quantity);
        self::assertSame($orderNumber, $response->orderDetails->orderNumber);
        self::assertSame('38', $response->orderDetails->totalGrossAmount);
        self::assertSame('26.5', $response->orderDetails->totalNetAmount);
        self::assertInstanceOf(\DateTime::class, $response->orderDetails->updatedAt);
        self::assertInstanceOf(Payment::class, $response->payment);
        self::assertSame([], $response->refunds);
    }

    public function testGetOrderCanceled(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $this->cancel($orderNumber);

        $response = $this->orders->getOrder($orderNumber);

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
        $captureNumber = $this->capture($orderNumber);

        $response = $this->orders->getOrder($orderNumber);

        self::assertSame([], $response->cancellations);
        self::assertInstanceOf(Capture::class, $response->captures[0]);
        self::assertSame('38', $response->captures[0]->amount);
        self::assertSame('38', $response->captures[0]->balance);
        self::assertInstanceOf(CaptureItem::class, $response->captures[0]->captureItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->captures[0]->captureItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->captures[0]->captureItems[0]->quantity);
        self::assertSame($captureNumber, $response->captures[0]->captureNumber);
        self::assertSame('EUR', $response->captures[0]->currency);
        self::assertSame('', $response->captures[0]->customerNumber);
        self::assertNull($response->captures[0]->dueDate);
        self::assertInstanceOf(\DateTime::class, $response->captures[0]->insertedAt);
        self::assertNull($response->captures[0]->invoiceDate);
        self::assertInstanceOf(\DateTime::class, $response->captures[0]->orderDate);
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

        $response = $this->orders->getOrder($orderNumber);

        self::assertSame([], $response->cancellations);
        self::assertInstanceOf(Refund::class, $response->refunds[0]);
        self::assertSame('-12.5', $response->refunds[0]->amount);
        self::assertSame('-12.5', $response->refunds[0]->balance);
        self::assertSame($captureNumber, $response->refunds[0]->captureNumber);
        self::assertSame('EUR', $response->refunds[0]->currency);
        self::assertSame('', $response->refunds[0]->customerNumber);
        self::assertInstanceOf(\DateTime::class, $response->refunds[0]->insertedAt);
        self::assertSame($orderNumber, $response->refunds[0]->orderNumber);
        self::assertInstanceOf(RefundItem::class, $response->refunds[0]->refundItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->refunds[0]->refundItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->refunds[0]->refundItems[0]->quantity);
        self::assertSame($refundNumbers[0], $response->refunds[0]->refundNumber);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->refunds[0]->reservationId);
        self::assertNull($response->refunds[0]->updatedAt);
    }

    public function testGetOrderWithUnknownNumber(): void
    {
        $this->expectException(AfterPayException::class);

        $this->orders->getOrder('UNKNOWN');
    }

    public function testGetVoids(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $this->cancel($orderNumber);

        $response = $this->orders->getVoids($orderNumber);

        self::assertInstanceOf(Cancellation::class, $response->cancellations[0]);
        self::assertSame('38', $response->cancellations[0]->cancellationAmount);
        self::assertInstanceOf(CancellationItem::class, $response->cancellations[0]->cancellationItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->cancellations[0]->cancellationItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->cancellations[0]->cancellationItems[0]->quantity);
        self::assertSame($response->cancellations[0]->cancellationNo, $response->cancellations[0]->cancellationItems[0]->cancellationNumber);
        self::assertIsString($response->cancellations[0]->cancellationNo);
    }

    public function testGetVoidsWithUnknownOrder(): void
    {
        $this->expectException(AfterPayException::class);

        $this->orders->getVoids('UNKNOWN');
    }

    public function testGetVoid(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $this->cancel($orderNumber);

        $response = $this->orders->getVoid($orderNumber, $this->orders->getVoids($orderNumber)->cancellations[0]->cancellationNo);

        self::assertInstanceOf(Cancellation::class, $response->cancellations[0]);
        self::assertSame('38', $response->cancellations[0]->cancellationAmount);
        self::assertInstanceOf(CancellationItem::class, $response->cancellations[0]->cancellationItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->cancellations[0]->cancellationItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->cancellations[0]->cancellationItems[0]->quantity);
        self::assertSame($response->cancellations[0]->cancellationNo, $response->cancellations[0]->cancellationItems[0]->cancellationNumber);
        self::assertIsString($response->cancellations[0]->cancellationNo);
    }

    public function testGetVoidWithUnknownNumber(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $this->expectException(AfterPayException::class);

        $this->orders->getVoid($orderNumber, 'UNKNOWN');
    }

    public function testGetRefunds(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $captureNumber = $this->capture($orderNumber);
        $refundNumbers = $this->refund($orderNumber, $captureNumber);

        $response = $this->orders->getRefunds($orderNumber);

        self::assertInstanceOf(Refund::class, $response->refunds[0]);
        self::assertSame('-12.5', $response->refunds[0]->amount);
        self::assertSame('-12.5', $response->refunds[0]->balance);
        self::assertSame($captureNumber, $response->refunds[0]->captureNumber);
        self::assertSame('EUR', $response->refunds[0]->currency);
        self::assertSame('', $response->refunds[0]->customerNumber);
        self::assertInstanceOf(\DateTime::class, $response->refunds[0]->insertedAt);
        self::assertSame($orderNumber, $response->refunds[0]->orderNumber);
        self::assertInstanceOf(RefundItem::class, $response->refunds[0]->refundItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->refunds[0]->refundItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->refunds[0]->refundItems[0]->quantity);
        self::assertSame($refundNumbers[0], $response->refunds[0]->refundNumber);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->refunds[0]->reservationId);
        self::assertNull($response->refunds[0]->updatedAt);
    }

    public function testGetRefundsWithUnknownOrder(): void
    {
        $this->expectException(AfterPayException::class);

        $this->orders->getRefunds('UNKNOWN');
    }

    public function testGetRefund(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $captureNumber = $this->capture($orderNumber);
        $refundNumbers = $this->refund($orderNumber, $captureNumber);

        $response = $this->orders->getRefund($orderNumber, $refundNumbers[0]);

        self::assertInstanceOf(Refund::class, $response->refunds[0]);
        self::assertSame('-12.5', $response->refunds[0]->amount);
        self::assertSame('-12.5', $response->refunds[0]->balance);
        self::assertSame($captureNumber, $response->refunds[0]->captureNumber);
        self::assertSame('EUR', $response->refunds[0]->currency);
        self::assertSame('', $response->refunds[0]->customerNumber);
        self::assertInstanceOf(\DateTime::class, $response->refunds[0]->insertedAt);
        self::assertSame($orderNumber, $response->refunds[0]->orderNumber);
        self::assertInstanceOf(RefundItem::class, $response->refunds[0]->refundItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->refunds[0]->refundItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->refunds[0]->refundItems[0]->quantity);
        self::assertSame($refundNumbers[0], $response->refunds[0]->refundNumber);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->refunds[0]->reservationId);
        self::assertNull($response->refunds[0]->updatedAt);
    }

    public function testGetRefundWithUnknownNumber(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $this->expectException(AfterPayException::class);

        $this->orders->getRefund($orderNumber, 'UNKNOWN');
    }

    public function testGetCaptures(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $captureNumber = $this->capture($orderNumber);

        $response = $this->orders->getCaptures($orderNumber);

        self::assertInstanceOf(Capture::class, $response->captures[0]);
        self::assertSame('38', $response->captures[0]->amount);
        self::assertSame('38', $response->captures[0]->balance);
        self::assertInstanceOf(CaptureItem::class, $response->captures[0]->captureItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->captures[0]->captureItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->captures[0]->captureItems[0]->quantity);
        self::assertSame($captureNumber, $response->captures[0]->captureNumber);
        self::assertSame('EUR', $response->captures[0]->currency);
        self::assertSame('', $response->captures[0]->customerNumber);
        self::assertNull($response->captures[0]->dueDate);
        self::assertInstanceOf(\DateTime::class, $response->captures[0]->insertedAt);
        self::assertNull($response->captures[0]->invoiceDate);
        self::assertInstanceOf(\DateTime::class, $response->captures[0]->orderDate);
        self::assertSame($orderNumber, $response->captures[0]->orderNumber);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->captures[0]->reservationId);
        self::assertSame('0', $response->captures[0]->totalRefundedAmount);
        self::assertNull($response->captures[0]->updatedAt);
    }

    public function testGetCapturesWithUnknownOrder(): void
    {
        $this->expectException(AfterPayException::class);

        $this->orders->getCaptures('UNKNOWN');
    }

    public function testGetCapture(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $captureNumber = $this->capture($orderNumber);

        $response = $this->orders->getCapture($orderNumber, $captureNumber);

        self::assertInstanceOf(Capture::class, $response->captures[0]);
        self::assertSame('38', $response->captures[0]->amount);
        self::assertSame('38', $response->captures[0]->balance);
        self::assertInstanceOf(CaptureItem::class, $response->captures[0]->captureItems[0]);
        self::assertSame(TestData::orderItems()[0]->productId, $response->captures[0]->captureItems[0]->productId);
        self::assertSame(TestData::orderItems()[0]->quantity, (int) $response->captures[0]->captureItems[0]->quantity);
        self::assertSame($captureNumber, $response->captures[0]->captureNumber);
        self::assertSame('EUR', $response->captures[0]->currency);
        self::assertSame('', $response->captures[0]->customerNumber);
        self::assertNull($response->captures[0]->dueDate);
        self::assertInstanceOf(\DateTime::class, $response->captures[0]->insertedAt);
        self::assertNull($response->captures[0]->invoiceDate);
        self::assertInstanceOf(\DateTime::class, $response->captures[0]->orderDate);
        self::assertSame($orderNumber, $response->captures[0]->orderNumber);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->captures[0]->reservationId);
        self::assertSame('0', $response->captures[0]->totalRefundedAmount);
        self::assertNull($response->captures[0]->updatedAt);
    }

    public function testGetCaptureWithUnknownNumber(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $this->expectException(AfterPayException::class);

        $this->orders->getCapture($orderNumber, 'UNKNOWN');
    }

    public function testUpdateOrder(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        self::assertSame(TestData::orderItems()[0]->description, $this->orders->getOrder($orderNumber)->orderDetails->orderItems[0]->description);

        $request = new UpdateOrderRequest();
        $request->updateOrderSummary = TestData::orderSummary();
        $request->updateOrderSummary->items[0]->description .= ' MODIFIED';

        $response = $this->orders->updateOrder($orderNumber, $request);

        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->checkoutId);
        self::assertInstanceOf(\DateTime::class, $response->expirationDate);
        self::assertSame(Outcome::ACCEPTED, $response->outcome);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->reservationId);
        self::assertSame(TestData::orderItems()[0]->description.' MODIFIED', $this->orders->getOrder($orderNumber)->orderDetails->orderItems[0]->description);
    }

    public function testUpdateOrderWithUnknownNumber(): void
    {
        $request = new UpdateOrderRequest();
        $request->updateOrderSummary = TestData::orderSummary();

        $this->expectException(AfterPayException::class);

        $this->orders->updateOrder('UNKNOWN', $request);
    }
}