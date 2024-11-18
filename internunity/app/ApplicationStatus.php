<?php

namespace App;

enum ApplicationStatus : string
{
    case APPLIED = "applied";
    case INTERVIEWING = "interviewing";
    case REJECTED = "rejected";
    case SELECTED = "selected";
}
