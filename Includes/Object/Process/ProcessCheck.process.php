<?php

namespace Process;

/**
 * ProcessCheck
 */
class ProcessCheck
{    
    /**
     * Returns lenght of given string, integer or array
     *
     * @param  mixed $var
     * 
     * @return int
     */
    private function getCount( mixed $var )
    {
        return (double)match (gettype($var)) {
            'array' => count($var),
            'string' => strlen($var),
            'integer', 'double' => $var
        };
    }

    /**
     * Checks max length of given variable
     *
     * @param  int|array|string $var
     * @param  string $key
     * @param  int $length Max length
     * 
     * @throws \Exception\Notice If length of variable is greater than the limit
     * 
     * @return bool
     */
    public function maxLength( mixed $var, string $key, int $length )
    {
        if ($this->getCount($var) <= $length) {
            return true;
        }

        throw new \Exception\Notice($key . '_length_max');
    }

    /**
     * Checks max length of given variable
     *
     * @param  int|array|string $var
     * @param  string $key
     * @param  int $length Min length
     * 
     * @throws \Exception\Notice If length of variable is less than the limit
     * 
     * @return bool
     */
    public function minLength( mixed $var, string $key, int $length )
    {
        if ($this->getCount($var) >= $length) {
            return true;
        }

        throw new \Exception\Notice($key . '_length_min');
    }

    /**
     * Checks if given string contains valid characters
     *
     * @param  string $var
     * @param  string $key
     * 
     * @throws \Exception\Notice If given string coontains illegal characters
     * 
     * @return bool
     */
    private function characters( string $var, string $key )
    {
        if (preg_match("/^[\p{L}0-9\_\&]+\$/u", utf8_decode($var))) {
            return true;
        }
        
        throw new \Exception\Notice($key . '_characters');
        return false;
    }
    
    /**
     * Checks if given email is valid
     *
     * @param  string $email The email
     * 
     * @throws \Exception\Notice If given email is not valid
     * 
     * @return bool
     */
    public function email( string $email )
    {
        if ($this->minLength(var: $email, key: 'email', length: 4)) {
            if ($this->maxLength(var: $email, key: 'email', length: 254)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return true;
                }
                throw new \Exception\Notice('email_wrong');
            }
        }
        return false;
    }
    
    /**
     * Checks if given username is valid
     *
     * @param  string $userName The username
     * 
     * @throws \Exception\Notice If given username is not valid
     * 
     * @return bool
     */
    public function userName( string $userName )
    {
        if ($this->minLength(var: $userName, key: 'user_name', length: 4)) {
            if ($this->maxLength(var: $userName, key: 'user_name', length: 16)) {
                if ($this->characters(var: $userName, key: 'user_name')) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Checks if given passwords are same
     *
     * @param  string $password
     * @param  string $passwordComapre
     * 
     * @throws \Exception\Notice If given passwords are different
     * 
     * @return bool
     */
    public function passwordMatch( string $password, string $passwordComapre )
    {
        $hashed = null;
        if (strlen($password) === 60) {
            $hashed = $password;
            $clear = $passwordComapre;
        }

        if (strlen($passwordComapre) === 60) {
            $hashed = $passwordComapre;
            $clear = $password;
        }

        if (!empty($hashed)) {
            if (password_verify($clear, $hashed)) {
                return true;
            }
        }

        if ($password === $passwordComapre ) {
            return true;
        }

        throw new \Exception\Notice('user_password_no_match');
        return false;
    }
    
    /**
     * Checks if given password is valid
     *
     * @param  string $password The password
     * 
     * @throws \Exception\Notice If given password is not valid
     * 
     * @return bool
     */
    public function password( string $password )
    {
        if ($this->minLength(var: $password, key: 'user_password', length: 6)) {
            if ($this->maxLength(var: $password, key: 'user_password', length: 40)) {
                if ($this->characters(var: $password, key: 'user_password')) {
                    return true;
                }
            }
        }
        return false;
    }
}