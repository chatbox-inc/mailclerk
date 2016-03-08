<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/03/09
 * Time: 1:41
 */

namespace Chatbox\Mail;


interface MessageInterface
{
    public function getToList():array;

    public function getCcList():array;

    public function getBccList():array;

    public function getFrom();

    public function getSubject();

    public function getTextBody();

    public function getHtmlBody();

    public function getAttachments():array;

}