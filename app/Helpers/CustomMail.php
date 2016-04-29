<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use App\Exceptions\CustomMailException;

class CustomMail
{

    /**
     * Data must receive an array with the following structure:
     *   $data = [
     *      'to' => 'to@example.com',
     *      'to_name' => 'John Smith', //this element can be empty
     *      'from' => 'from@example.com',
     *      'from_name' => 'Another Name', //this element can be empty
     *      'subject' => 'Test subject',
     *      'template' => 'template_name',
     *      'template_vars' => ['var1' => $value, 'var2' => $value2, ....] //this can be empty
     *   ]
     * @param array $data
     */
    public function send($data, $mailType = 'all')
    {
        if ( ! $this->isEnabled($mailType)) {
            return;
        }

        $data['template_vars'] = isset($data['template_vars']) ? $data['template_vars'] : [];

        $this->validateData($data);

        Mail::send($data['template'], ['data' => $data['template_vars']], function ($m) use ($data) {

            if (isset($data['to_name'])) {
                $m->to($data['to'], $data['to_name']);
            } else {
                $m->to($data['to']);
            }

            if (isset($data['from_name'])) {
                $m->from($data['from'], $data['from_name']);
            } else {
                $m->from($data['from']);
            }

            $m->subject($data['subject']);
        });
    }

    /**
     * Check if the mail is enabled to be sent
     *
     * @param string $mailType
     * @return boolean
     */
    private function isEnabled($mailType)
    {
        $configs = config('app.mails_enabled');

        if ($configs['all']) {
            return (isset($configs[$mailType])) ? $configs[$mailType] : true;
        } else {
            return false;
        }
    }

    /**
     * Validate required fields before send the mail
     *
     * @param array $data
     * @throws CustomMailException
     */
    private function validateData($data)
    {
        $required_fields = ['to', 'from', 'subject', 'template'];

        foreach ($required_fields as $required) {
            if (!isset($data[$required]) || trim($data[$required]) == '') {
                throw new CustomMailException('Required field: ' . $required);
            }
        }
    }
}
