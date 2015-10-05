<?php

/*
 * This file is part of the FiveLab Certificate package.
 *
 * (c) FiveLab <mail@fivelab.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FiveLab\Component\Certificate\Exception;

/**
 * Control error with read/parse x509 certificates
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class ErrorReadX509CertificateException extends CertificateException
{
    /**
     * @var string
     */
    private $openSslError;

    /**
     * Construct
     *
     * @param string     $message
     * @param string     $openSslError
     * @param int        $code
     * @param \Exception $prev
     */
    public function __construct($message, $openSslError = null, $code = 0, \Exception $prev = null)
    {
        parent::__construct($message, $code, $prev);

        $this->openSslError = $openSslError;
    }

    /**
     * Get open ssl error
     *
     * @return string
     */
    public function getOpenSslError()
    {
        return $this->openSslError;
    }

    /**
     * Create a new exception instance via open ssl error
     *
     * @param int        $code
     * @param \Exception $prev
     *
     * @return ErrorReadX509CertificateException
     */
    public static function withOpenSslError($code = 0, \Exception $prev = null)
    {
        $openSslError = openssl_error_string();

        return new static('Error read certificate.', $openSslError, $code, $prev);
    }
}
