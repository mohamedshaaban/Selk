<?php
/**
 * Note : Code is released under the GNU LGPL
 *
 * Please do not change the header of this file
 *
 * This library is free software; you can redistribute it and/or modify it under the terms of the GNU
 * Lesser General Public License as published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * See the GNU Lesser General Public License for more details.
 */

/**
 * File:        BookPURequest.php
 * Project:     DHL API
 *
 * @author      Al-Fallouji Bashar
 * @version     0.1
 */

namespace DHL\Entity\GB;

use DHL\Entity\Base;

/**
 * BookPURequest Request model for DHL API
 */
class BookPURequestCustome extends Base
{
    /**
     * Is this object a subobject
     * @var boolean
     */
    protected $_isSubobject = false;

    /**
     * @var boolean
     * Render the schema version or not
     */
    protected $_displaySchemaVersion = true;

    /**
     * Name of the service
     * @var string
     */
    protected $_serviceName = 'BookPURequest';

    /**
     * @var string
     * Service XSD
     */
    protected $_serviceXSD = 'pickup-global-req.xsd.xsd';

    /**
     * Parameters to be send in the body
     * @var array
     */
    protected $_bodyParams = array(
        'RegionCode' => array(
            'type' => 'string',
            'required' => false,
            'subobject' => false,
            'comment' => 'RegionCode',
            'minLength' => '2',
            'maxLength' => '2',
            'enumeration' => 'AP,EU,AM',
        ),
        'Requestor' => array(
            'type' => 'Requestor',
            'required' => false,
            'subobject' => true,
        ),
        'Place' => array(
            'type' => 'Place',
            'required' => false,
            'subobject' => true,
        ),
        'Pickup' => array(
            'type' => 'Pickup',
            'required' => false,
            'subobject' => true,
        ),
        'PickupContact' => array(
            'type' => 'PickupContact',
            'required' => false,
            'subobject' => true,
        ),
        'ShipmentDetails' => array(
            'type' => 'ShipmentDetails',
            'required' => false,
            'subobject' => true,
        ),
    );
}
