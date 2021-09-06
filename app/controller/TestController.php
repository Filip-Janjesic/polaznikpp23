<?php

class TestController
{
    public function lozinka()
    {
        echo password_hash('a',PASSWORD_BCRYPT);
    }
}