<?php

/*
 * This file is part of the FiveLab Certificate package.
 *
 * (c) FiveLab <mail@fivelab.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FiveLab\Component\Certificate\X509;

use FiveLab\Component\Certificate\Exception\CertificateFileNotFoundException;
use FiveLab\Component\Certificate\Exception\CertificateFileNotReadableException;
use FiveLab\Component\Certificate\Exception\ErrorReadX509CertificateException;

/**
 * Work with X509 certificate
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class X509Certificate
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $serialNumber;

    /**
     * @var \DateTime
     */
    private $validFrom;

    /**
     * @var \DateTime
     */
    private $validTo;

    /**
     * @var Subject
     */
    private $subject;

    /**
     * @var Issuer
     */
    private $issuer;

    /**
     * Construct
     *
     * @param string $certificateContent
     *
     * @throws ErrorReadX509CertificateException
     */
    public function __construct($certificateContent)
    {
        $certificateInfo = openssl_x509_parse($certificateContent, true);

        if (false === $certificateInfo) {
            throw new ErrorReadX509CertificateException('Error with parse certificate.');
        }

        $this->name = $certificateInfo['name'];
        $this->version = $certificateInfo['version'];
        $this->serialNumber = $certificateInfo['serialNumber'];
        $this->hash = $certificateInfo['hash'];
        $this->validFrom = \DateTime::createFromFormat('U', $certificateInfo['validFrom_time_t']);
        $this->validTo = \DateTime::createFromFormat('U', $certificateInfo['validTo_time_t']);

        $subject = $certificateInfo['subject'];

        $this->subject = new Subject(
            isset($subject['UID']) ? $subject['UID'] : null,
            isset($subject['C']) ? $subject['C'] : null,
            isset($subject['CN']) ? $subject['CN'] : null,
            isset($subject['O']) ? $subject['O'] : null,
            isset($subject['OU']) ? $subject['OU'] : null
        );

        $issuer = $certificateInfo['issuer'];

        $this->issuer = new Issuer(
            isset($issuer['UID']) ? $issuer['UID'] : null,
            isset($issuer['C']) ? $issuer['C'] : null,
            isset($issuer['CN']) ? $issuer['CN'] : null,
            isset($issuer['O']) ? $issuer['O'] : null,
            isset($issuer['OU']) ? $issuer['OU'] : null
        );
    }

    /**
     * Create new instance from file
     *
     * @param string $filePath
     *
     * @return X509Certificate
     *
     * @throws CertificateFileNotFoundException
     * @throws CertificateFileNotReadableException
     */
    public static function createFromFile($filePath)
    {
        if (!file_exists($filePath) || !is_file($filePath)) {
            throw new CertificateFileNotFoundException(sprintf(
                'Not found certificate file "%s".',
                $filePath
            ));
        }

        if (!is_readable($filePath)) {
            throw new CertificateFileNotReadableException(sprintf(
                'Can not read certificate file "%s".',
                $filePath
            ));
        }

        $content = file_get_contents($filePath);

        return new static($content);
    }

    /**
     * Get name of certificate
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get version of certificate
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get hash of certificate
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get serial number of certificate
     *
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * Get valid from
     *
     * @return \DateTime
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * Get valid to
     *
     * @return \DateTime
     */
    public function getValidTo()
    {
        return $this->validTo;
    }

    /**
     * Is this certificate valid
     *
     * @return bool
     */
    public function isValid()
    {
        $now = new \DateTime();

        return $now < $this->getValidTo();
    }

    /**
     * Get subject
     *
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get issuer
     *
     * @return Issuer
     */
    public function getIssuer()
    {
        return $this->issuer;
    }
}
