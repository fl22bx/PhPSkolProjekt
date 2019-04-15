<?php 
namespace View;
interface IDivHtml
{
    public function response();
    public function setMessage(string $message);
    public function setUser(\Model\LogInModel\User $user = null) : void;
}