<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/message.proto

namespace Zaly\Proto\Core;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>core.NoticeMessage</code>
 */
class NoticeMessage extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string body = 1;</code>
     */
    private $body = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $body
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Core\Message::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string body = 1;</code>
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Generated from protobuf field <code>string body = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setBody($var)
    {
        GPBUtil::checkString($var, True);
        $this->body = $var;

        return $this;
    }

}
