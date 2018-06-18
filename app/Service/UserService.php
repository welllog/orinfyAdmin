<?php

namespace App\Service;

use App\Exceptions\OrException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $pwdCost = 12;

    /**
     * 后台用户登录
     */
    public function auth(string $username, string $password, bool $remember)
    {
        $user = User::where('username', $username)->first();

        $error = '用户名或密码错误';
        if (null === $user) throw new OrException($error);
        if (User::NOT_ACTIVE === $user->status) throw new OrException($error);
        $res = password_verify($password, $user->password);
        if ($res === false) throw new OrException($error);

        Auth::guard()->login($user, $remember);
        (new User())->cacheRules($user->id);

    }

    public function updatePwd(string $password, User $user) : bool
    {
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => $this->pwdCost]);
        if ($password === $user->password) return true;
        $user->password = $password;
        return $user->save();
    }

    public function createUser(array $data) : bool
    {
        // 删除后台用户为软删除，因此手动验证mobile跟email
        $userModel = new User();
        $res = $userModel->isUnique('mobile', $data['mobile']);
        if (!$res) throw new OrException('该手机号已被使用');
        $res = $userModel->isUnique('email', $data['email']);
        if (!$res) throw new OrException('该邮箱已被使用');
        $data['status'] = 1;
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => $this->pwdCost]);
        $user = User::create($data);
        if ($user) {
            $user->roles()->sync($data['role_id']);
            return true;
        }
        return false;
    }

    public function updateUser(array $data, User $user) : bool
    {
        if ($user->username != $data['username']) {
            $res = $user->isUnique('username', $data['username']);
            if (!$res) throw new OrException('该用户名已被占用');
        }
        if ($data['email'] && ($data['email'] != $user->email)) {
            $res = $user->isUnique('email', $data['email']);
            if (!$res) throw new OrException('该邮箱已被占用');
        }
        if ($data['mobile'] && ($data['mobile'] != $user->mobile)) {
            $res = $user->isUnique('mobile', $data['mobile']);
            if (!$res) throw new OrException('该手机号被占用');
        }
        $res = $user->update($data);
        if ($res) {
            $user->roles()->sync($data['role_id']);
            return true;
        }
        return false;
    }

}