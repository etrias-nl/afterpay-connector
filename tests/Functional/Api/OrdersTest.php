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
use Etrias\AfterPayConnector\Type\RefundType;

/**
 * @internal
 */
final class OrdersTest extends ApiTestCase
{
    public function testAuthorizePayment(): void
    {
        $payment = new Payment();
        $payment->setType(Payment::TYPE_INVOICE);

        $request = new AuthorizePaymentRequest();
        $request
            ->setPayment($payment)
            ->setCustomer(TestData::checkoutCustomer())
            ->setOrder(TestData::order())
        ;

        $response = $this->orders->authorizePayment($request);

        self::assertSame(Outcome::ACCEPTED, $response->getOutcome());
        self::assertSame('John', $response->getCustomer()->getFirstName());
        self::assertSame('Doe 😁', $response->getCustomer()->getLastName());
        self::assertSame('NL', $response->getCustomer()->getAddressList()[0]->getCountryCode());
        self::assertNull($response->getDeliveryCustomer());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->getCheckoutId());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->getReservationId());
        self::assertSame([], $response->getRiskCheckMessages());
    }

    public function testRejectedAuthorizePayment(): void
    {
        $payment = new Payment();
        $payment->setType(Payment::TYPE_INVOICE);

        $request = new AuthorizePaymentRequest();
        $request
            ->setPayment($payment)
            ->setCustomer(TestData::checkoutCustomer())
            ->setOrder(TestData::order())
        ;

        $request->getCustomer()->setFirstName('Reject');

        $response = $this->orders->authorizePayment($request);

        self::assertSame(Outcome::REJECTED, $response->getOutcome());
        self::assertNotEmpty($response->getRiskCheckMessages());
    }

    public function testAvailablePaymentMethods(): void
    {
        $request = new AvailablePaymentMethodsRequest();
        $request
            ->setCustomer(TestData::checkoutCustomer())
            ->setOrder(TestData::order())
        ;

        $response = $this->orders->getAvailablePaymentMethods($request);

        self::assertSame(Outcome::ACCEPTED, $response->getOutcome());
        self::assertSame('John', $response->getCustomer()->getFirstName());
        self::assertSame('Doe 😁', $response->getCustomer()->getLastName());
        self::assertSame('NL', $response->getCustomer()->getAddressList()[0]->getCountryCode());
        self::assertNull($response->getDeliveryCustomer());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->getCheckoutId());
        self::assertIsString($response->getPaymentMethods()[0]->getTitle());
    }

    public function testCapturePayment(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $request = new CaptureRequest();
        $request->setOrderDetails(TestData::orderSummary());

        $response = $this->orders->capturePayment($orderNumber, $request);

        self::assertSame('38', $response->getAuthorizedAmount());
        self::assertSame('38', $response->getCapturedAmount());
        self::assertIsString($response->getCaptureNumber());
        self::assertSame('0', $response->getRemainingAuthorizedAmount());
    }

    public function testCapturePaymentWithUnknownOrder(): void
    {
        $request = new CaptureRequest();
        $request->setOrderDetails(TestData::orderSummary());

        $this->expectException(AfterPayException::class);

        $this->orders->capturePayment('UNKNOWN', $request);
    }

    public function testVoidAuthorization(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $request = new VoidAuthorizationRequest();
        $request->setCancellationDetails(TestData::orderSummary());

        $response = $this->orders->voidAuthorization($orderNumber, $request);

        self::assertSame('0', $response->getRemainingAuthorizedAmount());
        self::assertSame('38', $response->getTotalAuthorizedAmount());
        self::assertSame('0', $response->getTotalCapturedAmount());
    }

    public function testRefundPayment(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $captureNumber = $this->capture($orderNumber);

        $request = new RefundOrderRequest();
        $request
            ->setCaptureNumber($captureNumber)
            ->setRefundType(RefundType::REFUND)
            ->setItems([TestData::refundOrderItem()])
        ;

        $response = $this->orders->refundPayment($orderNumber, $request);

        self::assertIsString($response->getRefundNumbers()[0]);
        self::assertSame('38', $response->getTotalAuthorizedAmount());
        self::assertSame('38', $response->getTotalCapturedAmount());
        self::assertSame('12.5', $response->getTotalRefundedAmount());
    }

    public function testGetOrder(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $response = $this->orders->getOrder($orderNumber);
        $details = $response->getOrderDetails();

        self::assertSame([], $response->getCancellations());
        self::assertSame([], $response->getCaptures());
        self::assertSame('EUR', $details->getCurrency());
        self::assertInstanceOf(\DateTime::class, $details->getExpirationDate());
        self::assertInstanceOf(\DateTime::class, $details->getInsertedAt());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $details->getOrderId());
        self::assertInstanceOf(OrderItemExtended::class, $details->getOrderItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $details->getOrderItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $details->getOrderItems()[0]->getQuantity());
        self::assertSame($orderNumber, $details->getOrderNumber());
        self::assertSame('38', $details->getTotalGrossAmount());
        self::assertSame('26.5', $details->getTotalNetAmount());
        self::assertInstanceOf(\DateTime::class, $details->getUpdatedAt());
        self::assertInstanceOf(Payment::class, $response->getPayment());
        self::assertSame([], $response->getRefunds());
    }

    public function testGetOrderCanceled(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $this->cancel($orderNumber);

        $response = $this->orders->getOrder($orderNumber);
        $cancellations = $response->getCancellations();

        self::assertInstanceOf(Cancellation::class, $cancellations[0]);
        self::assertSame('38', $cancellations[0]->getCancellationAmount());
        self::assertInstanceOf(CancellationItem::class, $cancellations[0]->getCancellationItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $cancellations[0]->getCancellationItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $cancellations[0]->getCancellationItems()[0]->getQuantity());
        self::assertSame($cancellations[0]->getCancellationNo(), $cancellations[0]->getCancellationItems()[0]->getCancellationNumber());
        self::assertIsString($cancellations[0]->getCancellationNo());
        self::assertSame([], $response->getCaptures());
        self::assertSame([], $response->getRefunds());
    }

    public function testGetOrderCaptured(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $captureNumber = $this->capture($orderNumber);

        $response = $this->orders->getOrder($orderNumber);
        $captures = $response->getCaptures();

        self::assertSame([], $response->getCancellations());
        self::assertInstanceOf(Capture::class, $captures[0]);
        self::assertSame('38', $captures[0]->getAmount());
        self::assertSame('38', $captures[0]->getBalance());
        self::assertInstanceOf(CaptureItem::class, $captures[0]->getCaptureItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $captures[0]->getCaptureItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $captures[0]->getCaptureItems()[0]->getQuantity());
        self::assertSame($captureNumber, $captures[0]->getCaptureNumber());
        self::assertSame('EUR', $captures[0]->getCurrency());
        self::assertNotEmpty($captures[0]->getCustomerNumber());
        self::assertNull($captures[0]->getDueDate());
        self::assertInstanceOf(\DateTime::class, $captures[0]->getInsertedAt());
        self::assertNull($captures[0]->getInvoiceDate());
        self::assertInstanceOf(\DateTime::class, $captures[0]->getOrderDate());
        self::assertSame($orderNumber, $captures[0]->getOrderNumber());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $captures[0]->getReservationId());
        self::assertSame('0', $captures[0]->getTotalRefundedAmount());
        self::assertNull($captures[0]->getUpdatedAt());
        self::assertSame([], $response->getRefunds());
    }

    public function testGetOrderRefunded(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());
        $captureNumber = $this->capture($orderNumber);
        $refundNumbers = $this->refund($orderNumber, $captureNumber);

        $response = $this->orders->getOrder($orderNumber);
        $refunds = $response->getRefunds();

        self::assertSame([], $response->getCancellations());
        self::assertInstanceOf(Refund::class, $refunds[0]);
        self::assertSame('-12.5', $refunds[0]->getAmount());
        self::assertSame('-12.5', $refunds[0]->getBalance());
        self::assertSame($captureNumber, $refunds[0]->getCaptureNumber());
        self::assertSame('EUR', $refunds[0]->getCurrency());
        self::assertNotEmpty($refunds[0]->getCustomerNumber());
        self::assertInstanceOf(\DateTime::class, $refunds[0]->getInsertedAt());
        self::assertSame($orderNumber, $refunds[0]->getOrderNumber());
        self::assertInstanceOf(RefundItem::class, $refunds[0]->getRefundItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $refunds[0]->getRefundItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $refunds[0]->getRefundItems()[0]->getQuantity());
        self::assertSame($refundNumbers[0], $refunds[0]->getRefundNumber());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $refunds[0]->getReservationId());
        self::assertNull($refunds[0]->getUpdatedAt());
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
        $cancellations = $response->getCancellations();

        self::assertInstanceOf(Cancellation::class, $cancellations[0]);
        self::assertSame('38', $cancellations[0]->getCancellationAmount());
        self::assertInstanceOf(CancellationItem::class, $cancellations[0]->getCancellationItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $cancellations[0]->getCancellationItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $cancellations[0]->getCancellationItems()[0]->getQuantity());
        self::assertSame($cancellations[0]->getCancellationNo(), $cancellations[0]->getCancellationItems()[0]->getCancellationNumber());
        self::assertIsString($cancellations[0]->getCancellationNo());
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
        $voidNumber = $this->orders->getVoids($orderNumber)->getCancellations()[0]->getCancellationNo();

        $response = $this->orders->getVoid($orderNumber, $voidNumber);
        $cancellations = $response->getCancellations();

        self::assertInstanceOf(Cancellation::class, $cancellations[0]);
        self::assertSame('38', $cancellations[0]->getCancellationAmount());
        self::assertInstanceOf(CancellationItem::class, $cancellations[0]->getCancellationItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $cancellations[0]->getCancellationItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $cancellations[0]->getCancellationItems()[0]->getQuantity());
        self::assertSame($cancellations[0]->getCancellationNo(), $cancellations[0]->getCancellationItems()[0]->getCancellationNumber());
        self::assertIsString($cancellations[0]->getCancellationNo());
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
        $refunds = $response->getRefunds();

        self::assertInstanceOf(Refund::class, $refunds[0]);
        self::assertSame('-12.5', $refunds[0]->getAmount());
        self::assertSame('-12.5', $refunds[0]->getBalance());
        self::assertSame($captureNumber, $refunds[0]->getCaptureNumber());
        self::assertSame('EUR', $refunds[0]->getCurrency());
        self::assertNotEmpty($refunds[0]->getCustomerNumber());
        self::assertInstanceOf(\DateTime::class, $refunds[0]->getInsertedAt());
        self::assertSame($orderNumber, $refunds[0]->getOrderNumber());
        self::assertInstanceOf(RefundItem::class, $refunds[0]->getRefundItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $refunds[0]->getRefundItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $refunds[0]->getRefundItems()[0]->getQuantity());
        self::assertSame($refundNumbers[0], $refunds[0]->getRefundNumber());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $refunds[0]->getReservationId());
        self::assertNull($refunds[0]->getUpdatedAt());
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
        $refunds = $response->getRefunds();

        self::assertInstanceOf(Refund::class, $refunds[0]);
        self::assertSame('-12.5', $refunds[0]->getAmount());
        self::assertSame('-12.5', $refunds[0]->getBalance());
        self::assertSame($captureNumber, $refunds[0]->getCaptureNumber());
        self::assertSame('EUR', $refunds[0]->getCurrency());
        self::assertNotEmpty($refunds[0]->getCustomerNumber());
        self::assertInstanceOf(\DateTime::class, $refunds[0]->getInsertedAt());
        self::assertSame($orderNumber, $refunds[0]->getOrderNumber());
        self::assertInstanceOf(RefundItem::class, $refunds[0]->getRefundItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $refunds[0]->getRefundItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $refunds[0]->getRefundItems()[0]->getQuantity());
        self::assertSame($refundNumbers[0], $refunds[0]->getRefundNumber());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $refunds[0]->getReservationId());
        self::assertNull($refunds[0]->getUpdatedAt());
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
        $captures = $response->getCaptures();

        self::assertInstanceOf(Capture::class, $captures[0]);
        self::assertSame('38', $captures[0]->getAmount());
        self::assertSame('38', $captures[0]->getBalance());
        self::assertInstanceOf(CaptureItem::class, $captures[0]->getCaptureItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $captures[0]->getCaptureItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $captures[0]->getCaptureItems()[0]->getQuantity());
        self::assertSame($captureNumber, $captures[0]->getCaptureNumber());
        self::assertSame('EUR', $captures[0]->getCurrency());
        self::assertNotEmpty($captures[0]->getCustomerNumber());
        self::assertNull($captures[0]->getDueDate());
        self::assertInstanceOf(\DateTime::class, $captures[0]->getInsertedAt());
        self::assertNull($captures[0]->getInvoiceDate());
        self::assertInstanceOf(\DateTime::class, $captures[0]->getOrderDate());
        self::assertSame($orderNumber, $captures[0]->getOrderNumber());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $captures[0]->getReservationId());
        self::assertSame('0', $captures[0]->getTotalRefundedAmount());
        self::assertNull($captures[0]->getUpdatedAt());
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
        $captures = $response->getCaptures();

        self::assertInstanceOf(Capture::class, $captures[0]);
        self::assertSame('38', $captures[0]->getAmount());
        self::assertSame('38', $captures[0]->getBalance());
        self::assertInstanceOf(CaptureItem::class, $captures[0]->getCaptureItems()[0]);
        self::assertSame(TestData::orderItems()[0]->getProductId(), $captures[0]->getCaptureItems()[0]->getProductId());
        self::assertSame(TestData::orderItems()[0]->getQuantity(), (int) $captures[0]->getCaptureItems()[0]->getQuantity());
        self::assertSame($captureNumber, $captures[0]->getCaptureNumber());
        self::assertSame('EUR', $captures[0]->getCurrency());
        self::assertNotEmpty($captures[0]->getCustomerNumber());
        self::assertNull($captures[0]->getDueDate());
        self::assertInstanceOf(\DateTime::class, $captures[0]->getInsertedAt());
        self::assertNull($captures[0]->getInvoiceDate());
        self::assertInstanceOf(\DateTime::class, $captures[0]->getOrderDate());
        self::assertSame($orderNumber, $captures[0]->getOrderNumber());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $captures[0]->getReservationId());
        self::assertSame('0', $captures[0]->getTotalRefundedAmount());
        self::assertNull($captures[0]->getUpdatedAt());
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
        $order = $this->orders->getOrder($orderNumber);

        self::assertSame(TestData::orderItems()[0]->getDescription(), $order->getOrderDetails()->getOrderItems()[0]->getDescription());

        $request = new UpdateOrderRequest();
        $request->setUpdateOrderSummary(TestData::orderSummary());
        $request->getUpdateOrderSummary()->getItems()[0]->setDescription(__METHOD__);

        $response = $this->orders->updateOrder($orderNumber, $request);

        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->getCheckoutId());
        self::assertInstanceOf(\DateTime::class, $response->getExpirationDate());
        self::assertSame(Outcome::ACCEPTED, $response->getOutcome());
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->getReservationId());
        self::assertSame(__METHOD__, $this->orders->getOrder($orderNumber)->getOrderDetails()->getOrderItems()[0]->getDescription());
    }

    public function testUpdateOrderWithUnknownNumber(): void
    {
        $request = new UpdateOrderRequest();
        $request->setUpdateOrderSummary(TestData::orderSummary());

        $this->expectException(AfterPayException::class);

        $this->orders->updateOrder('UNKNOWN', $request);
    }
}
