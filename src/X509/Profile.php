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

/**
 * Profile (Subject/Issuer) of X509 certificate
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
abstract class Profile
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $commonName;

    /**
     * @var string
     */
    private $organizationName;

    /**
     * @var string
     */
    private $organizationUnitName;

    /**
     * Construct
     *
     * @param string $identifier
     * @param string $country
     * @param string $commonName
     * @param string $organizationName
     * @param string $organizationUnitName
     */
    public function __construct($identifier, $country, $commonName, $organizationName, $organizationUnitName)
    {
        $this->identifier = $identifier;
        $this->country = $country;
        $this->commonName = $commonName;
        $this->organizationName = $organizationName;
        $this->organizationUnitName = $organizationUnitName;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get common name
     *
     * @return string
     */
    public function getCommonName()
    {
        return $this->commonName;
    }

    /**
     * Get organization name
     *
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * Get organization unit name
     *
     * @return string
     */
    public function getOrganizationUnitName()
    {
        return $this->organizationUnitName;
    }
}
