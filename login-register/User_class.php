
<?php class User
// класс для всех переменных, которые будут храниться в базе данных и которые нужны пользователю, реализованны геттера и сеттеры
{
    private $first_name;
    private $last_name;
    private $company_name;
    private $position;
    private $email;
    private $password;
    private $repeat_password;
    private $mobile_1;
    private $mobile_2;
    private $mobile_3;

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }
    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getCompanyName()
    {
        return $this->company_name;
    }

    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }
    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getRepeatPassword()
    {
        return $this->repeat_password;
    }

    public function setRepeatPassword($repeat_password)
    {
        $this->repeat_password = $repeat_password;
    }
    public function getMobile1()
    {
        return $this->mobile_1;
    }

    public function setMobile1($mobile_1)
    {
        $this->mobile_1 = $mobile_1;
    }
    public function getMobile2()
    {
        return $this->mobile_2;
    }

    public function setMobile2($mobile_2)
    {
        $this->mobile_2 = $mobile_2;
    }
    public function getMobile3()
    {
        return $this->mobile_3;
    }

    public function setMobile3($mobile_3)
    {
        $this->mobile_3 = $mobile_3;
    }
}
