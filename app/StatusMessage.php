<?php

namespace App;


class StatusMessage
{
    const COMMON_FAIL = 'Something bad has been happened. Please try again later.';
    const COMMON_SUCCESS = '';
    const RESOURCE_CREATED = 'Resource has been created successfully.';
    const RESOURCE_UPDATED = 'Resource has been updated successfully.';
    const RESOURCE_NOT_FOUND = 'Requested resource has not been found.';
    const MAINTENANCE_MODE = 'Our service is under maintenance. Please try again later.';
    const VALIDATION_ERROR = 'Invalid data has been provided.';
}