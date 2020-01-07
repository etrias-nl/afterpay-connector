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
    public $type;

    /** @var null|string */
    public $code;

    /** @var null|string */
    public $actionCode;

    /** @var null|string */
    public $message;

    /** @var null|string */
    public $customerFacingMessage;

    /** @var null|string */
    public $fieldReference;

    public function toExceptionMessage(): string
    {
        $message = $this->message ?? $this->customerFacingMessage ?? 'An unknown error occurred.';
        $labels = array_filter(['code' => $this->code, 'action_code' => $this->actionCode]);

        if ($labels) {
            $message .= ' ('.json_encode($labels).')';
        }

        return null === $this->fieldReference ? $message : 'Error for field "'.$this->fieldReference.'": '.$message;
    }
}
