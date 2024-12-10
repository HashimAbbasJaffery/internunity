<?php

namespace App;

enum ApplicationTypes: string
{
    case APPLIED = 'applied';
    case INTERVIEW = 'interview';
    case SELECTED = 'selected';
    case REJECTED = 'rejected';
}
