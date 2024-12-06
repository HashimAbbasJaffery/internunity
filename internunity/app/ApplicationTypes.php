<?php

namespace App;

enum ApplicationTypes: string
{
    case APPLIED = 'applied';
    case INTERVIEW = 'interviewing';
    case SELECTED = 'selected';
    case REJECTED = 'rejected';
}
