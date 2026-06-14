<?php

namespace App\Enums;

/**
 * Les rôles possibles d'un utilisateur.
 * La valeur (string) est ce qui est stocké en base.
 */
enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case Coach = 'coach';
    case Member = 'member';
}
