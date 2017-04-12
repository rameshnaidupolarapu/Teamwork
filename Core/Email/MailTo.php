<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailTo
 *
 * @author venkatesh
 */
namespace Core\Email;
class MailTo 
{
    //put your code here
    public function sendMail()
    {
        try
        {
        // the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("rameshnaidupolarapu@gmail.com","My subject",$msg);
        }
                catch(Exception $e)
                {
                            echo $e->getMessage();
                }
    }
}
