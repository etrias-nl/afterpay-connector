<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class ResponseMessage
{
    public const TYPE_BUSINESS_ERROR = 'BusinessError';
    public const TYPE_TECHNICAL_ERROR = 'TechnicalError';
    public const TYPE_NOTIFICATION_MESSAGE = 'NotificationMessage';

    public const ACTION_CODE_UNAVAILABLE = 'Unavailable';
    public const ACTION_CODE_CONFIRM = 'AskConsumerToConfirm';
    public const ACTION_CODE_REENTER_DATA = 'AskConsumerToReEnterData';
    public const ACTION_CODE_SECURE_PAYMENT_METHODS = 'OfferSecurePaymentMethods';
    public const ACTION_CODE_REQUIRE_SSN = 'RequiresSsn';
    public const ACTION_CODE_IDENTIFY = 'AskConsumerToIdentify';

    /** @var null|string */
    protected $type;

    /** @var null|string */
    protected $code;

    /** @var null|string */
    protected $actionCode;

    /** @var null|string */
    protected $message;

    /** @var null|string */
    protected $customerFacingMessage;

    /** @var null|string */
    protected $fieldReference;

    public function toExceptionMessage(): string
    {
        $message = $this->message ?? $this->customerFacingMessage ?? 'An unknown error occurred.';
        $labels = array_filter(['code' => $this->code, 'action_code' => $this->actionCode]);

        if ($labels) {
            $message .= ' ('.json_encode($labels).')';
        }

        return null === $this->fieldReference || '' === $this->fieldReference ? $message : 'Error for field "'.$this->fieldReference.'": '.$message;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getActionCode(): ?string
    {
        return $this->actionCode;
    }

    public function setActionCode(?string $actionCode): self
    {
        $this->actionCode = $actionCode;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCustomerFacingMessage(): ?string
    {
        return $this->customerFacingMessage;
    }

    public function setCustomerFacingMessage(?string $customerFacingMessage): self
    {
        $this->customerFacingMessage = $customerFacingMessage;

        return $this;
    }

    public function getFieldReference(): ?string
    {
        return $this->fieldReference;
    }

    public function setFieldReference(?string $fieldReference): self
    {
        $this->fieldReference = $fieldReference;

        return $this;
    }
}
