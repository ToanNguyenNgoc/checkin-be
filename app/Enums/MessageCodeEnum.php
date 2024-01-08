<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MessageCodeEnum extends Enum
{   
    /* LOGIN STATUS CODE */
    const USER_NAME_OR_PASSWORD_INCORRECT = 'USER_NAME_OR_PASSWORD_INCORRECT';
    const LOGIN_SUCCESS = 'LOGIN_SUCCESS';
    const TOO_MANY_LOGIN_ATTEMP = 'TOO_MANY_LOGIN_ATTEMP';
}
