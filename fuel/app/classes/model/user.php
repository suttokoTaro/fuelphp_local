<?php
class Model_User extends \Orm\Model
{
    public static function get_all_users()
    {
        $query = 'SELECT * FROM users';
        return \DB::query($query)->execute()->as_array();
    }
    public static function get_by_username($username)
    {
        return self::query()->where('username', $username)->get_one();
    }

    public static function generate_random_email($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $domains = ['example.com', 'dummy.com', 'test.com', 'fakeemail.com'];
        $randomDomain = $domains[array_rand($domains)];
        return $randomString . '@' . $randomDomain;
    }
}