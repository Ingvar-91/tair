<?php

namespace App\Http\Controllers\Api\v1\Site;

use App\Http\Controllers\Api\v1\RestController;

class ContactsController extends RestController {

    public function getAllNumbers() {
        $this->data['contacts'] = config('app.contacts.wdContacts');
        $this->data['path'] = config('app.apiUrl').config('filesystems.logo.path');
        return $this->success($this->data);
    }

}
