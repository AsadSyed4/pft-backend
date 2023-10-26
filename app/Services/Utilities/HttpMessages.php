<?php

namespace App\Services\Utilities;

enum HttpMessages: string
{
    case Created = "Record Inserted!";
    case Failed = "Operation Failed!";
    case Found = "Records Found!";
    case Registered = "Registered!";
    case Updated = "Record Updated!";
    case Archived = "Record Archived!";
    case Unauthorized = "Not Authorized! Access Token is Missing! OR Expired! OR Already Revoked!";
    case TokenRevoked = "Access Token Revoked!";
    case KeyMissing = "Access/Secret Key Missing!";
    case NotFound = "Record Not Found!";
    case Deleted = "Record Deleted!";
    case ServiceUnavailable = "Failed!";
    case LoggedIn = "Login Successfully!";
    case LoggedOut = "Logout Successfully!";
    case NotExist = "Not Exist!";
    case Exist = "Exist!";
    case SessionNotFound = "Session Doesn't Exist!";

}
