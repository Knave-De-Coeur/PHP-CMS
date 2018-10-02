<?php
/**
 * Created by PhpStorm.
 * User: knave-de-coeur
 * Date: 02/10/18
 * Time: 16:51
 */

echo password_hash('secret', PASSWORD_BCRYPT, array('cost' => 12) );