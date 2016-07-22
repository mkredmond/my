<?php

namespace App\Flash;

class Flash{
	/**
     * @param  string         $title
     * @param  string         $message
     * @param  string         $level
     * @param  string|null    $key
     * @return void
     */
    public function create($title, $message, $level, $key = 'flash_message')
    {
        session()->flash($key, [
            'title'   => $title,
            'message' => $message,
            'level'   => $level,
        ]);
    }

    /**
     * @param  string     $title
     * @param  string     $message
     * @return void
     */
    public function info($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    /**
     * @param  string     $title
     * @param  string     $message
     * @return void
     */
    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    /**
     * @param  string     $title
     * @param  string     $message
     * @return void
     */
    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }

    /**
     * @param  string     $title
     * @param  string     $message
     * @param  string     $level [ defaults to success but can be error or info ]
     * @return void
     */
    public function overlay($title, $message, $level = 'success')
    {
        return $this->create($title, $message, $level, 'flash_message_overlay');
    }
}