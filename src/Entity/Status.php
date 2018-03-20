<?php

declare(strict_types=1);

namespace App\Entity;
use Nette\Utils\Json;

/**
 * Class Status
 * @package App\Entity
 */
class Status
{
    const STATUS_SUCCESS = 'success',
        STATUS_ERROR = 'error';

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * Status constructor.
     * @param string $status
     * @param string $message
     */
    public function __construct(string $status, string $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return Json::encode([
            'status' => $this->status,
            'message' => $this->message,
        ]);
    }
}
