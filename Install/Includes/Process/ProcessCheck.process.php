<?php

namespace Process;

/**
 * Check process data
 */
class ProcessCheck {
    
    /**
     * @var array $inputData Loaded data
     */
    public $inputData;

    /**
     * @var array $noticeName Current checking string name
     */
    public $noticeName;

    /**
     * Checks max length of given string
     *
     * @param  string $inputName
     * @param  int $lenght
     * @return bool
     */
    public function maxLength( string $string, string $key = null, int $lenght )
    {
        if (strlen($string) <= $lenght) {
            return true;
        }

        throw new \Exception\Notice($key ?: $this->noticeName . '_max_length');
        return false;
    }

    /**
     * Checks max length of given string
     *
     * @param  string $inputName
     * @param  int $lenght
     * @return bool
     */
    public function minLength( string $string, string $key = null, int $lenght )
    {
        if (strlen($string) >= $lenght) {
            return true;
        }

        throw new \Exception\Notice($key ?: $this->noticeName . '_min_length');
        return false;
    }

    /**
     * Checks if given string contains valid characters
     *
     * @param  string $string
     * @return bool
     */
    private function characters( string $string, string $key = null)
    {
        if (preg_match("/^[\p{L}0-9\_\&]+\$/u", utf8_decode($string))) {
            return true;
        }
        
        throw new \Exception\Notice($key ?: $this->noticeName . '_characters');
        return false;
    }
    
    /**
     * Checks if given email is valid
     *
     * @param  string $email
     * @return bool
     */
    public function email( string $email )
    {
        $this->noticeName = 'user_email';

        if ($this->minLength(string: $email, lenght: 4)) {
            if ($this->maxLength(string: $email, lenght: 254)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return true;
                }
                throw new \Exception\Notice($this->noticeName);
            }
        }
        return false;
    }
    
    /**
     * Checks if given user name is valid
     *
     * @param  string $userName
     * @return bool
     */
    public function userName( string $userName )
    {
        $this->noticeName = 'user_name';

        if ($this->minLength(string: $userName, lenght: 4)) {
            if ($this->maxLength(string: $userName, lenght: 16)) {
                if ($this->characters($userName)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * Checks if given password is valid
     *
     * @param  string $password
     * @return bool
     */
    public function password( string $password )
    {
        $this->noticeName = 'user_password';

        if ($this->minLength(string: $password, lenght: 6)) {
            if ($this->maxLength(string: $password, lenght: 40)) {
                if ($this->characters($password)) {
                    return true;
                }
            }
        }
        return false;
    }
}