<?php

declare(strict_types=1);

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Latent\ElAdmin\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckPassword implements Rule
{
    /**
     * 确定验证规则是否通过。
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_null($value) || empty($value)) {
            return true;
        }

        if (6 > strlen($value) || strlen($value) > 20) {
            return false;
        }

        return true;
    }

    /**
     * 获取验证错误消息。
     *
     * @return string
     */
    public function message()
    {
        return trans('el_admin.password');
    }
}
